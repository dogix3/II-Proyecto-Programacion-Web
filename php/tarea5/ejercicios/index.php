<?php
// leer xml
// escribir json

// lo primero seria bueno convertir el xml a pata a json y leerlo en el codigo de lectura de json y ver si el resultado es lelido correctamente..
// No es necesario mostrar el json pero jsonlint.com nos puede validar el resultado json

$path = "XMLCountryList.xml";

if (!file_exists($path))
    exit("File not found");
$xml = XMLReader::open($path);
$paises = array();
echo "<html><body><table border=1>";
echo "<tr><th>code</th><th>handle</th><th>continent</th><th>iso</th></tr>";

while ($xml->read())
if ($xml->nodeType == XMLReader::ELEMENT && $xml->name == 'country') {
    $fields = array();
    $fields[0] = $xml->getAttribute('code');
    $fields[1] = $xml->getAttribute('handle');
    $fields[2] = $xml->getAttribute('continent');
    $fields[3] = $xml->getAttribute('iso');
	$paises[]= array('code'=>$fields[0], 'handle'=>$fields[1], 'continent'=>$fields[2], 'iso'=>$fields[3]);
}
echo "</table></body></html>";
$xml->close();


$path = "XMLCountryList.json";
$file = fopen($path, "w");

/*$countries = array(
    array("name"=>"Belice","area"=>"22966","people"=>"334000","density"=>"14.54"),
    array("name"=>"Costa Rica","area"=>"51100","people"=>"4726000","density"=>"92.49")
);*/


$json = json_encode($paises);
fwrite($file, $json);
fclose($file);

?>











<?php
/*

// Lectura JSON
$path = "XMLCountryList.json";

if (!file_exists($path))
    exit("File not found");

$data = file_get_contents($path);
$json = json_decode($data, true);

echo "<html><body><table border=1>";
echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
foreach ($json['countries'] as $row) {
    echo "<tr><td>".$row['name']."</td><td>".$row['area']."</td><td>".
         $row['people']."</td><td>".$row['density']."</td></tr>";
}
echo "</table></body></html>";
*/
?>