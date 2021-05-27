<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if (isset($_POST["val"]))
{
    $this_var = $_POST["val"] + 1;
    echo json_encode(array('value' => $this_var));
}
?>
