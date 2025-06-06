<!DOCTYPE html>
<html>
<body>
    <?php
        // imports
        require_once('cart_class.php');
        require_once 'format.php';

        // from format.php for access levels, https://www.w3schools.com/php/php_oop_interfaces.asp
        class CatalogueFormat implements InfoFormat {
            private $products;
            private $statistics = null;
            
            // setup the product array
            public function setProducts($products, $statistics = null) {
                $this->products = $products;
                $this->statistics = $statistics;
            }

            // logic for cusotmer view (default)
            public function customerLayout(): string {
                $html = "<h2>Catalogue - Customer View</h2>";
                foreach ($this->products as $item) {
                    $html .= $this->renderItem($item, true);
                }
                return $html;
            }

            // logic for shipper view 
            // need to change stuff to shipping related stuff
            // only diff right now is that you can't add to cart cos shippers don't have a cart
            public function shipperLayout(): string {
                $html = "<h2>Catalogue - Shipper View</h2>";
                foreach ($this->products as $item) {
                    // disable add to cart if a shipper
                    $html .= $this->renderItem($item, false);
                }
                return $html;
            }

            // logic for administrative view
            // cart is also disabled but prolly need to fix this to interact with order stuff
            // NEED TO ADD STATISTICS AND ACCESS ORDER RECORD
            public function adminLayout(): string {
                $html = "<h2>Catalogue - Administrative View</h2>";
                foreach ($this->products as $item) {
                    // disable add to cart if a admin <-- TEMPORARY ADD SPECIFIC STUFF FOR REORDERING
                    $html .= $this->renderItem($item, false); 
                    // stats stuff
                    if ($this->statistics !== null) {
                        $name = $item->get_item_name();
                        $purchases = $this->statistics->get_item_purchases($name);
                        $html .= "<p><strong>Total Purchased:</strong> $purchases</p>";
                    } else {
                        $html .= "<p><em>Statistics: unavailable</em></p>";
                    }
                }
                return $html;
            }

            private function renderItem($item, $includeForm): string {
                // boxes for items
                $html = "<div style='border:1px solid #ccc; margin:10px; padding:10px'>";
                $html .= "<strong>{$item->get_item_name()}</strong><br>";
                $html .= "Price: \${$item->get_item_price()}<br>";
                $html .= "Remaining: {$item->get_item_remaining_quantity()}<br>";
                $html .= "Description: {$item->get_item_long_desc()}<br>";

                // form for adding to cart 
                if ($includeForm && $item->get_item_remaining_quantity() > 0) {
                    $html .= "
                        <form method='POST'>
                            <input type='hidden' name='item_id' value='{$item->get_item_id()}'>
                            <label>Quantity:</label>
                            <input type='number' name='quantity' value='1' min='1' max='{$item->get_item_remaining_quantity()}'>
                            <input type='submit' value='Add to Cart'>
                        </form>
                    ";
                }
                $html .= "</div>";
                return $html;
            }
        }
        ?>
</body>
</html>
