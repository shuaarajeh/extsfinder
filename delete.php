<?php
$title="Delete |Telephone Extension Finder";
include('header.php');
$message = '';
$error = '';
$flag=true;
if (isset($_POST["submit"])) {
    if (empty($_POST["number"])) {
        $error = "<label class='text-danger'>Enter Name Please</label>";
    } else {//chek for number if it is exist

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
            }else{
                $data = file_get_contents('data.json');

                $json_arr = json_decode($data, true);
        
                $arr_index = array();
                foreach ($json_arr as $key => $value) {
                    if ($value['number'] == $_POST["number"]) {
                        $arr_index[] = $key;
                    }
                }
                if(empty($arr_index)){
                        $error = "<label class='text-danger'>This Number Does Not Exit</label>";
                        $flag= false;
                }
            }

            
        }
        else{
            $error = "<label class='text-danger' >Please enter numeric value</label>";
            $flag=false;
        }
       if($flag) {
        foreach ($arr_index as $i) {
            unset($json_arr[$i]);
        }

        $json_arr = array_values($json_arr);

        if (file_put_contents('data.json', json_encode($json_arr))) {
            $message = "<label class='text-success'> Deleted </label>";
        } else {
            $message = "<label class='text-success'>something went wrong</label>";
        }
    }
    }
}
?>
<div class="container" style="width:500px;">

    <h3 align="">Delete an extension</h3><br />
    <form method="post">
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <br />
        <label>Number</label>
       
        <input type="text" name="number" class="form-control" /><br />
        <div class="btns">
        <input type="submit" name="submit" value="Delete" class="btn" /><br />
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