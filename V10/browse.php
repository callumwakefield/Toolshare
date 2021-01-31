<?php
    include('server.php');



    // gets the search values

    

?>

<html>
<head>
    <title>Brows tools</title>
    <meta charset="utf8"> 
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="icon" href="images/icon.png">
</head>
<body>
<div class="banner">
        <div class="Toolshare">
            Tool share    
        </div>
        <?php include('nav.php')?>
    </div>

    <form method="post" class="search_frm">
    
        <?php include("errors.php"); ?>
        
        <p> 
            
            <label class="search-title">Browse:</label>

            <label>Tool type:</label>

            <input type="text" name="tool_request">

            <label>Location:</label>

            <input type="text" name="location_request">

            <button type="submit" class="search-btn" name="search">
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
                            echo "<h4>please serch for a tool</h4>";
                }
                else {

                    //querys
                    $tool_qry = "SELECT 
                            r.region AS region,
                            tr.tool AS tool,
                            tr.additional_items AS additional_items,
                            tr.description AS description,
                            tr.availability AS availability,
                            tr.comments AS comments,
                            tr.id AS tool_id
                        FROM tool_registry AS tr INNER JOIN registration AS r
                        ON tr.owner_id = r.id WHERE region LIKE '%$location_request%' AND tool LIKE '%$tool_request%'";

                    $result = mysqli_query($db, $tool_qry);

                    

                    if (mysqli_num_rows($result) > 0) {

                        //sets up the table
                        echo '<table class="search-table">
                        <tr>
                            <th colspan="1">Tool Name:</th>
                            <th colspan="2">Additional items:</th>
                            <th colspan="2">location:</th>
                            <th colspan="1">View record:</th>
                        </tr>';

                        //output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            //sets the value of the variables to what is in the field
                            $tool = $row["tool"];
                            $additional_items = $row["additional_items"];
                            $location = $row["region"];
                            $tool_id = $row["tool_id"];

                            if (boolval($row["availability"]) == TRUE) {

                                ?>
                                <tr>
                                    <td colspan="1">
                                        <?php
                                            echo $tool;
                                        ?>
                                    </td>
                                    <td colspan="2">
                                        <?php 
                                            echo $additional_items;
                                        ?>
                                    </td>
                                    <td colspan="2">
                                        <?php
                                            echo $location; 
                                        ?>
                                    </td>
                                    <td colspan="1"><a href='veiw_record.php?id=<?php echo $tool_id; ?>'>veiw details</a></td>
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