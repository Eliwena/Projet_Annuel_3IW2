<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Administration</title>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <!-- FONT AWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">
    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.js"></script>
    <!-- STYLE -->
    <link href="Resources/styles.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="nav-top">
        <a href="#" class="logo-link">
            <img class="logo-img" src="Resources/images/logo.svg" alt="Administration" style="width: 100px !important;">
        </a>
        <nav class="navigation-top">
            <ul>
                <li>
                    <span>Bonjour Kevin</span>
                    <a href="#open-dropdown">
                        <img class="profil-img" src="https://placehold.it/60x60" alt="" />
                        <i class="fas fa-chevron-down"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<main>
    <div class="sidebar">
        <ul>
            <li>
                <a href="#">
                    <i class="fas fa-tachometer-alt"></i>
                    Tableau de bord
                </a>
            </li>
            <li class="active">
                <a href="./membres.php">
                    <i class="fas fa-user"></i>
                    Utilisateurs
                </a>
            </li>
            <hr class="separation_nav">
            <li>
                <a href="#">
                    <i class="fas fa-fill-drip"></i>
                    Apparence
                </a>
            </li>
            <li class="sousmenu">
                <a href="./menus.php">
                    Mes thèmes
                </a>
            </li>
            <li class="sousmenu">
                <a href="./menus.php">
                    Mon en-tête
                </a>
            </li>
            <li class="sousmenu">
                <a href="./menus.php">
                    Mon corps
                </a>
            </li>
            <li class="sousmenu">
                <a href="./menus.php">
                    Mon bas de page
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-shopping-cart"></i>
                    Commande
                </a>
            </li>
            <hr class="separation_nav">
            <li>
                <a href="#">
                    <i class="fas fa-hamburger"></i>
                    A la carte
                </a>
            </li>
            <li class="sousmenu">
                <a href="./menus.php">
                    Mes menus
                </a>
            </li>
            <li class="sousmenu">
                <a href="./menus.php">
                    Mes plats
                </a>
            </li>
            <li class="sousmenu">
                <a href="./menus.php">
                    Mes produits bruts
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-car-side"></i>
                    Reservation
                </a>
            </li>
            <hr class="separation_nav">

            <li class="bottom">
                <a href="#">
                    <i class="fas fa-cog"></i>
                    Paramètre
                </a>
            </li>
        </ul>
    </div>
        <div class="content">

            <h1>Les membres</h1>

            <table id="table_members" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Olivia Liang</td>
                    <td>Support Engineer</td>
                    <td>Singapore</td>
                    <td>64</td>
                    <td>2011/02/03</td>
                    <td>$234,500</td>
                </tr>
                <tr>
                    <td>Bruno Nash</td>
                    <td>Software Engineer</td>
                    <td>London</td>
                    <td>38</td>
                    <td>2011/05/03</td>
                    <td>$163,500</td>
                </tr>
                <tr>
                    <td>Sakura Yamamoto</td>
                    <td>Support Engineer</td>
                    <td>Tokyo</td>
                    <td>37</td>
                    <td>2009/08/19</td>
                    <td>$139,575</td>
                </tr>
                <tr>
                    <td>Thor Walton</td>
                    <td>Developer</td>
                    <td>New York</td>
                    <td>61</td>
                    <td>2013/08/11</td>
                    <td>$98,540</td>
                </tr>
                <tr>
                    <td>Finn Camacho</td>
                    <td>Support Engineer</td>
                    <td>San Francisco</td>
                    <td>47</td>
                    <td>2009/07/07</td>
                    <td>$87,500</td>
                </tr>
                <tr>
                    <td>Serge Baldwin</td>
                    <td>Data Coordinator</td>
                    <td>Singapore</td>
                    <td>64</td>
                    <td>2012/04/09</td>
                    <td>$138,575</td>
                </tr>
                <tr>
                    <td>Zenaida Frank</td>
                    <td>Software Engineer</td>
                    <td>New York</td>
                    <td>63</td>
                    <td>2010/01/04</td>
                    <td>$125,250</td>
                </tr>
                <tr>
                    <td>Zorita Serrano</td>
                    <td>Software Engineer</td>
                    <td>San Francisco</td>
                    <td>56</td>
                    <td>2012/06/01</td>
                    <td>$115,000</td>
                </tr>
                <tr>
                    <td>Jennifer Acosta</td>
                    <td>Junior Javascript Developer</td>
                    <td>Edinburgh</td>
                    <td>43</td>
                    <td>2013/02/01</td>
                    <td>$75,650</td>
                </tr>
                <tr>
                    <td>Cara Stevens</td>
                    <td>Sales Assistant</td>
                    <td>New York</td>
                    <td>46</td>
                    <td>2011/12/06</td>
                    <td>$145,600</td>
                </tr>
                <tr>
                    <td>Hermione Butler</td>
                    <td>Regional Director</td>
                    <td>London</td>
                    <td>47</td>
                    <td>2011/03/21</td>
                    <td>$356,250</td>
                </tr>
                <tr>
                    <td>Lael Greer</td>
                    <td>Systems Administrator</td>
                    <td>London</td>
                    <td>21</td>
                    <td>2009/02/27</td>
                    <td>$103,500</td>
                </tr>
                <tr>
                    <td>Jonas Alexander</td>
                    <td>Developer</td>
                    <td>San Francisco</td>
                    <td>30</td>
                    <td>2010/07/14</td>
                    <td>$86,500</td>
                </tr>
                <tr>
                    <td>Shad Decker</td>
                    <td>Regional Director</td>
                    <td>Edinburgh</td>
                    <td>51</td>
                    <td>2008/11/13</td>
                    <td>$183,000</td>
                </tr>
                <tr>
                    <td>Michael Bruce</td>
                    <td>Javascript Developer</td>
                    <td>Singapore</td>
                    <td>29</td>
                    <td>2011/06/27</td>
                    <td>$183,000</td>
                </tr>
                <tr>
                    <td>Donna Snider</td>
                    <td>Customer Support</td>
                    <td>New York</td>
                    <td>27</td>
                    <td>2011/01/25</td>
                    <td>$112,000</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
                </tfoot>
            </table>


        </div>
    </main>
    <script>
        $(document).ready( function () {
            $('#table_members').DataTable();
        } );
    </script>
</body>
</html>