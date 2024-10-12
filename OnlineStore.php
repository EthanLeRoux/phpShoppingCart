<?php

class OnlineStore
{
    private $DBConnect;
    private $cart;
    private $ErrorMsgs = [];

    public function __construct($db)
    {
        $this->DBConnect = $db;
        session_start();
        $this->initializeCart();
    }

    private function initializeCart()
    {
        if (isset($_SESSION['cart'])) {
            $this->cart = $_SESSION['cart'];
        } else {
            $this->cart = array();
            $_SESSION['cart'] = $this->cart;
        }
    }

    public function showWelcomeMessage()
    {
        echo "Session ID: " . session_id() . "<br>";
        echo "Welcome Back " . $_SESSION['seshUser'] . "!";
    }

    public function fetchStoreInfo($storeID)
    {
        $TableName = "store_info";
        $SQLstring = "SELECT * FROM $TableName WHERE storeID = ?";
        $stmt = $this->DBConnect->prepare($SQLstring);
        $stmt->bind_param("s", $storeID);

        if (!$stmt->execute()) {
            $this->ErrorMsgs[] = "Unable to execute query: " . $this->DBConnect->error;
            return null;
        } else {
            return $stmt->get_result()->fetch_row();
        }
    }

    public function fetchInventory($storeID)
    {
        $inventory = [];
        $TableName = "inventory";
        $SQLstring = "SELECT * FROM $TableName WHERE storeID = ?";
        $stmt = $this->DBConnect->prepare($SQLstring);
        $stmt->bind_param("s", $storeID);

        if (!$stmt->execute()) {
            $this->ErrorMsgs[] = "Unable to execute query: " . $this->DBConnect->error;
        } else {
            $result = $stmt->get_result();
            while ($Row = $result->fetch_row()) {
                $inventory[] = $Row;
            }
        }
        return $inventory;
    }

    public function displayCart($storeId)
    {
        $total = 0;
        echo "<table width='100%' border='1'>\n";
        echo "<tr><th>Image</th><th>Store ID</th><th>Product ID</th><th>Name</th>" .
            "<th>Description</th><th>Price</th><th>Quantity</th><th>Actions</th></tr>\n";

        foreach ($this->fetchInventory($storeId) as $Row) {
            $ID = $Row[1];
            echo "<tr>";
            echo "<td><img src='img/{$Row[1]}.jpeg' height='100px' width='100px'></td>";
            echo "<td>{$Row[0]}</td>";
            echo "<td>{$Row[1]}</td>";
            echo "<td>{$Row[2]}</td>";
            echo "<td>{$Row[3]}</td>";
            echo "<td>{$Row[4]}</td>";
            echo "<td>" . ($this->cart[$ID] ?? 0) . "</td>";
            echo "<td><a href='?ItemToAdd=$ID'>Add</a> | <a href='?ItemToRemove=$ID'>Remove</a></td>";
            echo "</tr>\n";
            $total += $Row[4] * ($this->cart[$ID] ?? 0);
        }

        echo "<tr><td>Sub-Total</td><td colspan='5'>$total</td>";
        echo "<td><a href='?EmptyCart=1'>Empty Cart</a></td></tr>";
        echo "</table>";
    }

    public function addToCart($itemID)
    {
        if (isset($this->cart[$itemID])) {
            $this->cart[$itemID]++;
        } else {
            $this->cart[$itemID] = 1;
        }
        $_SESSION['cart'] = $this->cart;
    }

    public function removeFromCart($itemID)
    {
        if (isset($this->cart[$itemID]) && $this->cart[$itemID] > 1) {
            $this->cart[$itemID]--;
        } else {
            unset($this->cart[$itemID]);
        }
        $_SESSION['cart'] = $this->cart;
    }

    public function emptyCart()
    {
        $this->cart = [];
        $_SESSION['cart'] = $this->cart;
    }

    public function displayErrorMessages()
    {
        foreach ($this->ErrorMsgs as $msg) {
            echo "<p>$msg</p>";
        }
    }

    public function closeConnection()
    {
        if ($this->DBConnect) {
            $this->DBConnect->close();
        }
    }
}

