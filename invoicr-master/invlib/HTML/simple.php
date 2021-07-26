<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "php_posv3";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . nysqli_connect_error());
}

//Transaction Table
$transactionQuery = "SELECT * FROM transaction WHERE TransID=".$this->items;
$transactionTable = mysqli_query($conn, $transactionQuery);

// (A) HTML HEADER & STYLES
$this->data = "<!DOCTYPE html><html><head><style>".
"html,body{font-family:sans-serif}#invoice{max-width:800px;margin:0 auto}#bigi{margin-bottom:20px;font-size:28px;font-weight:bold;color:#ad132f;padding:10px}#company,#billship{margin-bottom:30px}#company img{max-width:180px;height:auto}#billship,#company,#items{width:100%;border-collapse:collapse}#billship td{width:33%}#billship td,#items td,#items th{padding:10px}#items th{text-align:left;border-top:2px solid #000;border-bottom:2px solid #000}#items td{border-bottom:1px solid #ccc}.idesc{color:#999}.ttl{background:#fafafa;font-weight:700}.right{text-align:right}#notes{background:#efefef;padding:10px;margin-top:30px}".
"</style></head><body><div id='invoice'>";

// (B) COMPANY
$this->data .= "<table id='company'><tr><td><img src='".$this->company[0]."'/></td><td class='right'>";
for ($i=2;$i<count($this->company);$i++) {
	$this->data .= "<div>".$this->company[$i]."</div>";
}
$this->data .= "</td></tr></table>";
$this->data .= "<div id='bigi'>SALES INVOICE</div>";

// (C) BILL TO
$this->data .= "<table id='billship'><tr><td><strong>BILL TO</strong><br>";
foreach ($this->billto as $b) { $this->data .= $b."<br>"; }

// (D) SHIP TO
$this->data .= "</td><td><strong>ADDRESS</strong><br>";
foreach ($this->shipto as $s) { $this->data .= $s."<br>"; }

// (E) INVOICE INFO
$this->data .= "</td><td>";
foreach ($this->head as $i) {
	$this->data .= "<strong>$i[0]:</strong> $i[1]<br>";
}
$this->data .= "</td></tr></table>";

// (F) ITEMS
$this->data .= "<table id='items'><tr><th>Item</th><th>Price</th><th>Quantity</th><th>Amount</th></tr>";
while($rows=mysqli_fetch_assoc($transactionTable))
{
	//$this->data .= "<tr><td><div>".$rows['Product_Name']."</td><td>".$rows['Price']."</td><td>".$rows['Quantity']."</td><td>".$rows['Total']."</td></tr>";
	$this->data .= "<tr><td><div>".$rows['Product_Name']."</div>".($rows['Product_ID']==""?"":"<small class='idesc'>$rows[Product_ID]</small>")."</td><td>".$rows['Price']."</td><td>".$rows['Quantity']."</td><td>".$rows['Total']."</td></tr>";
}

// (G) TOTALS
if (count($this->totals)>0) { foreach ($this->totals as $t) {
	$this->data .= "<tr class='ttl'><td class='right' colspan='3'>$t[0]</td><td>$t[1]</td></tr>";
}}
$this->data .= "</table>";


// (H) NOTES
if (count($this->notes)>0) {
	$this->data .= "<div id='notes'>";
	foreach ($this->notes as $n) {
		$this->data .= $n."<br>";
	}
	$this->data .= "</div>";
}

// (I) CLOSE
$this->data .= "</div></body></html>";