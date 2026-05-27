{
  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixos-24.05";
    flake-utils.url = "github:numtide/flake-utils";
  };

  outputs =
    { self, nixpkgs, flake-utils, ... }:
    flake-utils.lib.eachDefaultSystem (
      system:
      let
        pkgs = nixpkgs.legacyPackages.${system};
        php = pkgs.php83;
        lib = pkgs.lib;

        filteredSrc = lib.cleanSourceWith {
          filter = name: type: let
            base = builtins.baseNameOf name;
          in !(builtins.elem base [ "node_modules" "vendor" ".env" "deploy.php" ]);
          src = lib.cleanSource ./.;
        };
      in
      {
        devShells.default = pkgs.mkShell {
          packages = [ php pkgs.php83Packages.composer pkgs.bun ];
        };

        packages.job-rss = lib.makeOverridable
          (args: let
            version = args.version or "0.1.0";
            env = args.env or { };
          in
            let
              bunDeps = pkgs.stdenv.mkDerivation {
                pname = "job-rss-bun-deps";
                inherit version;
                src = filteredSrc;
                nativeBuildInputs = [ pkgs.bun ];
                buildPhase = ''
                  export HOME=$TMPDIR
                  bun install --frozen-lockfile --omit=dev
                  mkdir -p "$out/node_modules"
                  cp -r node_modules/. "$out/node_modules/"
                '';
                installPhase = "true";
                outputHashMode = "recursive";
                outputHashAlgo = "sha256";
                outputHash = "sha256-m/AoZgrQZ+cIPpm4M3tAA1IFsxvWJobok5Oofi10xQc=";
              };
            in
            php.buildComposerProject (finalAttrs: {
              pname = "job-rss";
              inherit version;
              src = filteredSrc;
              composerLock = ./composer.lock;
              vendorHash = "sha256-L6G3rl2/vpNVBk1qf45c8a3mTcS23Jbtl1b+Z5MfNgk=";

              nativeBuildInputs = [ pkgs.bun ];

              composerNoDev = true;
              composerNoPlugins = true;
              composerNoScripts = true;
              composerStrictValidation = true;

              buildPhase = ''
                runHook preBuild

                cp -rL ${bunDeps}/node_modules ./node_modules
                chmod -R +w ./node_modules
                export HOME=$TMPDIR

                # Run vite directly via bun to avoid shebang dependency on /usr/bin/env
                bun ./node_modules/vite/bin/vite.js build

                runHook postBuild
              '';

              postInstall = ''
                cd "$out/share/php/job-rss"

                cat > .env << EOF
                APP_ENV=production
                APP_DEBUG=false
                APP_KEY=base64:sOmEfAkEkEyF0rBuIldPhaSeOnLy=
                EOF

                php artisan package:discover
                php artisan route:cache
                php artisan view:cache

                rm -f .env
                rm -rf node_modules tests .git docker-compose.yml \
                  .editorconfig .env.example .gitattributes .gitignore \
                  flake.nix flake.lock phpcs.xml phpunit.xml \
                  package.json bun.lockb postcss.config.js \
                  tailwind.config.js vite.config.js README.md \
                  .phpunit.result.cache _ide_helper_models.php
              '';

              meta = {
                description = "Job RSS - Laravel job aggregator";
                homepage = "https://github.com/marvielb/job-rss";
                license = lib.licenses.mit;
                platforms = lib.platforms.linux;
              };
            }))
          {};

        packages.default = self.packages.${system}.job-rss;
      }
    );
}
