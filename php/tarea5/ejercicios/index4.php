<?php

$path = "data3.html";

$writer = new XMLWriter();
$writer->openURI($path);
$writer->startDocument('1.0');
//$writer = new DomDocument('1.0');
//$writer->preserveWhiteSpace = false;
$writer->formatOutput = true;
$writer->startElement('html');$writer->text("\n");
	$writer->startElement('head');$writer->text("\n");
		$writer->startElement('title');
			$writer->text("Pagina");
		$writer->endElement();$writer->text("\n"); // title

		$writer->startElement('style');
			$writer->writeAttribute('type', 'text/css');
			$writer->text("body{ font-family: Helvetica; }");
		$writer->endElement();$writer->text("\n"); // style
	$writer->endElement();$writer->text("\n"); // head

	$writer->startElement('body');$writer->text("\n");

		$writer->startElement('h1');
			$writer->text("Carlos Leon");
		$writer->endElement();

		$writer->startElement('table');
			$writer->startElement('tbody');

				$writer->startElement('tr');
					$writer->startElement('td');
						$writer->text("Progra Web");
					$writer->endElement(); // td
					$writer->startElement('td');
						$writer->text("6 pm");
					$writer->endElement(); // td
				$writer->endElement(); // tr

				$writer->startElement('tr');
					$writer->startElement('td');
						$writer->text("Diseño Web");
					$writer->endElement(); // td
					$writer->startElement('td');
						$writer->text("6 pm");
					$writer->endElement(); // td
				$writer->endElement(); // tr


				$writer->startElement('tr');
					$writer->startElement('td');
						$writer->text("Admin Proyectos");
					$writer->endElement(); // td
					$writer->startElement('td');
						$writer->text("6 pm");
					$writer->endElement(); // td
				$writer->endElement(); // tr
			$writer->endElement(); // tbody
		$writer->endElement(); // table
	

	/*$writer->startElement('country');

	$writer->writeAttribute('name', 'Belice');
	$writer->writeAttribute('area', '22966');
	$writer->writeAttribute('people', '334000');
	$writer->writeAttribute('density', '14.54');
	$writer->endElement();

	$writer->startElement('country');
	$writer->writeAttribute('name', 'Costa Rica');
	$writer->writeAttribute('area', '51100');
	$writer->writeAttribute('people', '4726000');
	$writer->writeAttribute('density', '92.49');
	$writer->endElement();*/

	$writer->endElement(); // body

$writer->endElement(); // html

$writer->flush();

?>