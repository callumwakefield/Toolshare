<?php
    include('server.php');



    // gets the search values

    

?>

<html>
<head>
    <title>Brows tools</title>
    <meta charset="utf8"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="images/icon.png">
</head>
<body>
    <?php include_once("nav.php"); ?>
    <h1>Browse tools</h1>

    <form method="post" class="search_frm">
    
        <?php include("errors.php"); ?>

        <p>
            <label>Tool type</label>

            <input type="text" name="tool_request">

            <label>Location</label>

            <input type="text" name="location_request">

            <button type="submit" class="btn" name="search">
                Search
            </button>

        </p>
    </form>

    <!-- Displays the data -->

    <div class="search-tbl">
        <?php 
            if (isset($_POST['search'])) {

                $tool_request = $_POST['tool_request'];
                $location_request = $_POST['location_request'];
                
                //checks to see if user has enterd anythin
                if ($tool_request == "" && 
                        $location_request == "") {

                            //prompts user to do a serch
                            echo "please serch for a tool";
                }
                else {

                    //querys
                    $tool_qry = "SELECT 
                            r.address AS address,
                            tr.tool AS tool,
                            tr.additional_items AS additional_items,
                            tr.comments AS comments,
                            tr.availability AS availability
                        FROM tool_registry AS tr INNER JOIN registration AS r
                        ON tr.owner_id = r.id WHERE address LIKE '%$location_request%' AND tool LIKE '%$tool_request%'";

                    $result = mysqli_query($db, $tool_qry);

                    

                    if (mysqli_num_rows($result) > 0) {

                        //sets up the table
                        echo '<table border="0" cellspacing="2" cellpadding="2">
                        <tr>
                            <th>Tool Name:</th>
                            <th>Description:</th>
                            <th>Additional items:</th>
                            <th>location:</th>
                        </tr>';

                        //output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            $tool = $row["tool"];
                            $comments = $row["comments"];
                            $additional_items = $row["additional_items"];
                            $location = $row["address"];

                            if (boolval($row["availability"]) == TRUE) {

                                ?>
                                <tr>
                                    <td><?php echo $tool; ?></td>
                                    <td><?php echo $comments; ?></td>
                                    <td><?php echo $additional_items; ?></td>
                                    <td><?php echo $location; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        
                    }
                    else {
                        echo "<h4>Apologies but no matches 
                            were found</h4>";
                    }
                }
            }
        
        ?>
    </div>



</body>
</html>