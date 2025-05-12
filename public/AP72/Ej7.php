<?php
require_once "autoloader.php";
$modelo = new Model();

//Paginador
$productsPerPage = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page-1) * $productsPerPage;
$totalProducts = $modelo->countProducts();   // Obtiene el total de productos
$totalPages = ceil($totalProducts / $productsPerPage); //redondeo por encima

// Obtener productos paginados
$productos = $modelo->getPaginatedProducts($productsPerPage, $offset);

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

          .depClass10{ background-color: red}
          .depClass20{ background-color: green}
          .depClass30{ background-color: blue}
          .depClass40{ background-color: purple}

          .star{
            width: 16px;
            height: 16px;
          }

    </style>
</head>
<body>
    <div class="divTable blueTable">
        <div class="divTableHeading">
        <div class="divTableRow">
        <div class="divTableHead">PROD_NUM</div>
        <div class="divTableHead">DESCRIPCION</div>
        </div>
        </div>
        <div class="divTableBody">
        <?php $modelo->showPaginatedProducts($productsPerPage, $offset) ?>
        </div>
        </div>
        
        <!--ESTILO 1 DE PAGINADOR-->
        
        <div>
            <?php if ($page > 1): ?>
                <a href="?page=1"><<</a>
                <a href="?page=<?php echo $page - 1; ?>"><</a>
            <?php endif; ?>
            <span>Página <?php echo $page; ?> de <?php echo $totalPages; ?></span>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">></a>
                <a href="?page=<?php echo $totalPages; ?>">>></a>
            <?php endif; ?>
        </div>
        <!--ESTILO 2 DE PAGINADOR-->
        <div class="blueTable outerTableFooter">
        <div class="tableFootStyle">
        <div class="links">
          <a href="?page=1">&laquo;</a>
          <?php for ($i=1;$i<=$totalPages;$i++){ 
                    if ($page==$i){?>
                      <a><?php echo $i; ?></a>
                    <?php }else{?>
                      <a class="active" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php }
                    
          } ?>
          <a href="?page=<?php echo $totalPages; ?>">&raquo;</a>
        </div>
        </div>
</body>
</html>