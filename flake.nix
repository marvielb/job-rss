{
  inputs.nixpkgs.url = "github:NixOS/nixpkgs/nixos-24.05";

  outputs =
    { nixpkgs, ... }:
    {
      /*
        This example assumes your system is x86_64-linux
        change as neccesary
      */
      devShells.x86_64-linux =
        let
          pkgs = nixpkgs.legacyPackages.x86_64-linux;
        in
        {
          default = pkgs.mkShell {
            packages = [ pkgs.php83 pkgs.bun ];
          };
        };
    };
}
