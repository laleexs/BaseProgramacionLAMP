<?php
require_once "autoloader.php";
$modelo = new Model();
$total = (isset($_GET["total"]) ? $_GET["total"] : null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        div.blueTable {
            border: 1px solid #1C6EA4;
            background-color: #EEEEEE;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
          }
          .divTable.blueTable .divTableCell, .divTable.blueTable .divTableHead {
            border: 1px solid #AAAAAA;
            padding: 3px 2px;
          }
          .divTable.blueTable .divTableBody .divTableCell {
            font-size: 13px;
          }
          .divTable.blueTable .divTableRow:nth-child(even) {
            background: #D0E4F5;
          }
          .divTable.blueTable .divTableHeading {
            background: #1C6EA4;
            background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            border-bottom: 2px solid #444444;
          }
          .divTable.blueTable .divTableHeading .divTableHead {
            font-size: 15px;
            font-weight: bold;
            color: #FFFFFF;
            border-left: 2px solid #D0E4F5;
          }
          .divTable.blueTable .divTableHeading .divTableHead:first-child {
            border-left: none;
          }
          
          .blueTable .tableFootStyle {
            font-size: 14px;
            font-weight: bold;
            color: #FFFFFF;
            background: #D0E4F5;
            background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            border-top: 2px solid #444444;
          }
          .blueTable .tableFootStyle {
            font-size: 14px;
          }
          .blueTable .tableFootStyle .links {
            text-align: right;
          }
          .blueTable .tableFootStyle .links a{
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
          }
          .blueTable.outerTableFooter {
            border-top: none;
          }
          .blueTable.outerTableFooter .tableFootStyle {
            padding: 3px 5px; 
          }
          /* DivTable.com */
          .divTable{ display: table; }
          .divTableRow { display: table-row; }
          .divTableHeading { display: table-header-group;}
          .divTableCell, .divTableHead { display: table-cell;}
          .divTableHeading { display: table-header-group;}
          .divTableFoot { display: table-footer-group;}
          .divTableBody { display: table-row-group;}

    </style>
</head>
<body>
    <div class="divTable blueTable">
        <div class="divTableHeading">
        <div class="divTableRow">
        <div class="divTableHead">PEDIDO_NUM</div>
        <div class="divTableHead">CLIENTE_COD</div>
        <div class="divTableHead">TOTAL</div>
        
        </div>
        </div>
        <div class="divTableBody">
        <?php $modelo->showOrder($total)?> 
        </div>
        </div>
        <div class="blueTable outerTableFooter">
        <div class="tableFootStyle">
        <div class="links"><a href="#">&laquo;</a> <a class="active" href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">&raquo;</a></div>
        </div>
        </div>
</body>
</html>