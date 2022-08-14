<?php
$title="Add |Telephone Extension Finder";
include('header.php');
$message = '';
$error = '';
$flag = true;
if (isset($_POST["submit"])) {
    if (empty($_POST["name"])) {
        $error = "<label class='text-danger'>Enter Name Please</label>";
    } else if (empty($_POST["number"])) {
        $error = "<label class='text-danger'>Enter Number Please</label>";
    } else {
        if (file_exists('data.json')) {
            $current_data = file_get_contents('data.json');
            $array_data = json_decode($current_data, true);
            $extra = array(
                'name' =>     $_POST['name'],
                'number' =>    $_POST["number"]
            );
           
            if(is_numeric($_POST["number"])==1){//check if it is numeric value
                $num = $_POST["number"];
                $count = 0;
                while ($num!=0){ //check length of the number
                    $num = intdiv($num,10);
                    $count++;
                }
                if($count!=4){
                    $error = "<label class='text-danger'>Number should be in length 4</label>";
                    $flag=false;
                }

                if(is_numeric($_POST["name"])==1){
                    $error = "<label class='text-danger'>Name should not be numeric</label>";
                    $flag=false;
                }
                foreach ($array_data as $key => $person) {
                    if($person['number'] == $_POST['number']){
                        $flag = false;
                        $error = "<label class='text-danger'>This Number Exits</label>";
                        break;
    
                    }else if ($person['name'] == $_POST['name']) {
                        $flag = false;
                        $error = "<label class='text-danger'>This Name Exits</label>"; 
                        break;
                    }
    
    
                }

            } else{
                $error = "<label class='text-danger' >Please enter numeric value</label>";
                $flag=false;
            }

            
            if ($flag==true) {
                $array_data[] = $extra;
                $final_data = json_encode($array_data);
                if (file_put_contents('data.json', $final_data)) {
                    $message = "<label class='text-success'>Extension Added Successfully</label>";
                } else {
                    $message = "<label class='text-danger'>Something Went Wrong</label>";
                }
                $current_data = file_get_contents('data.json');
            }
        } else {
            $error = 'JSON File not exits';
        }
    }
}

?>

<div class="container" id="container" style="width:500px;">

    <h3 align="">Add new extension</h3><br />
    <form method="post">
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <br />
        <label>Name</label>
       
        <input type="text" name="name" class="form-control" /><br />
        <label>Number</label>
        <input type="text" name="number" class="form-control" /><br />
        <div class="btns">
        <input type="submit" name="submit" value="Add" class="btn" /><br />
        <a href="index.php" class="btn">back home</a>
    </div>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
    </form>
    
</div>
<?php include('footer.php'); ?>