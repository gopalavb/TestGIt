  <?php 
  include('conn.php');  // include your code to connect to DB.
    //$tbl_name="";       //your table name
    $adjacents = 3;

    /* $query = "SELECT COUNT(*) as num FROM $tbl_name";
    $total_pages = mysqli_fetch_array(mysqli_query($query));
    $total_pages = $total_pages[num]; */
    
    
    $sql1 = "SELECT count(*) FROM `transaction`";
    $result1 = $conn->prepare($sql1);
    $result1->execute();
    $total_pages = $result1->fetchColumn();


    $targetpage = "filename.php";   //your file name  (the name of this file)
    $limit = 15;                                //how many items to show per page
    $page = $_GET['page'];
    if($page) 
        $start = ($page - 1) * $limit;          //first item to display on this page
    else
        $start = 0;                             //if no page var is given, set start to 0

    /* Get data. */
    /* $sql = "SELECT column_name FROM $tbl_name LIMIT $start, $limit";
    $result = mysqli_query($sql); */
    
    
    $sql2 = "SELECT id,AccessTime FROM `transaction`  LIMIT $start, $limit";
    $result = $conn->query($sql2);
    
    

    /* Setup page vars for display. */
    if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
    $prev = $page - 1;                          //previous page is page - 1
    $next = $page + 1;                          //next page is page + 1
    $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;                      //last page minus 1

    /* 
        Now we apply our rules and draw the pagination object. 
        We're actually saving the code to a variable in case we want to draw it more than once.
    */
    $pagination = "";
    if($lastpage > 1)
    {   
        $pagination .= "<div class=\"pagination\">";
        //previous button
        if ($page > 1) 
            $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$prev\"><< previous</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
        else
            $pagination.= "<span class=\"disabled\"> previous &nbsp;&nbsp;|&nbsp;&nbsp;</span>"; 

        //pages 
        if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
        {   
            for ($counter = 1; $counter <= $lastpage; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class=\"current\">$counter</span>";
                else
                    $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$counter\">$counter</a>&nbsp;&nbsp;|&nbsp;&nbsp;";                 
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
        {
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 2))     
            {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"current\">$counter</span>";
                    else
                        $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$counter\">$counter</a>&nbsp;&nbsp;|&nbsp;&nbsp;";                 
                }
                $pagination.= "...";
                $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$lpm1\">$lpm1</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
                $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$lastpage\">$lastpage</a>&nbsp;&nbsp;|&nbsp;&nbsp;";       
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
            {
                $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=1\">1</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
                $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=2\">2</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
                $pagination.= "...";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"current\">$counter</span>";
                    else
                        $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$counter\">$counter</a>&nbsp;&nbsp;|&nbsp;&nbsp;";                 
                }
                $pagination.= "...";
                $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$lpm1\">$lpm1</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
                $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$lastpage\">$lastpage</a>&nbsp;&nbsp;|&nbsp;&nbsp;";       
            }
            //close to end; only hide early pages
            else
            {
                $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=1\">1</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
                $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=2\">2</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
                $pagination.= "...";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"current\">$counter</span>";
                    else
                        $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$counter\">$counter</a>&nbsp;&nbsp;|&nbsp;&nbsp;";                 
                }
            }
        }

        //next button
        if ($page < $counter - 1) 
            $pagination.= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$targetpage?page=$next\">next >></a>&nbsp;&nbsp;|&nbsp;&nbsp;";
        else
            $pagination.= "<span class=\"disabled\">&nbsp;&nbsp;|&nbsp;&nbsp;next</span>";
        $pagination.= "</div>\n";     
    }
?>

    <?php
       /*  while($row = mysqli_fetch_array($result))
        {

        // Your while loop here

        } */
        
        while($rows5 = $result->fetch())
        {
            $id_one = $rows5['id'];
            $AccessTime = $rows5['AccessTime'];
            echo"<br>$id_one, $AccessTime<br>";
        }
    ?>

<?=$pagination?>