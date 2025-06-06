<?php
class HomePage {
    public string $title = "AWE Electronics";
    public string $intro = "Welcome to AWE Electronics – powering your tech dreams! Browse our latest gadgets, make secure purchases, and enjoy fast shipping.";

    public function getNavbarItems(): array {
        return [
            "Home" => "index.php",
            "Shop" => "shop.php",
            "Cart" => "cart.php",
            "Log In" => "login.php"
        ];
    }
}
