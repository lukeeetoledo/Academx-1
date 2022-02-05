<?php
require "FPDF/fpdf.php";
$db = new PDO('mysql:host=localhost;dbname=academx_db','root','');


class myPDF extends FPDF{
    function header(){
        
        $this->Image('img/tablogo.png',10,6);
        $this->SetFont('Arial', 'B',25);
        $this->Cell(276,24, 'ACADEMX POST LIST',0,0,'C');
        $this->Ln(20);
        $this->SetFont('arial','',12);
        $this->Cell(276,0, 'Compilation of users in AcadeMx',0,0,'C');
        $this->Ln(10);
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C');        
    }
    function headerTable(){
        $this->SetFillColor(90,199,199);
        $this->SetFont('arial','B',12,);
        $this->Cell(17,10,'User ID',1,0,'C',true);
        $this->Cell(40,10,'First Name',1,0,'C',true);
        $this->Cell(30,10,'Last Name',1,0,'C',true);
        $this->Cell(30,10,'Sex',1,0,'C',true);
        $this->Cell(18,10,'Age',1,0,'C',true);
        $this->Cell(60,10,'Email',1,0,'C',true);
        $this->Cell(45,10,'Username',1,0,'C',true);
        $this->Cell(35,10,'Contact Number',1,0,'C',true);
        $this->Ln();
    }
    function viewTable($db){
        $this->SetFont('Times','',12);
        $ID=$_GET['token'];
        $stmt = $db->query("select * from amx_users_tbl where ID = '$ID'");
        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
            $this->SetFillColor(63,63,63);
            $this->SetFont('arial','',12);
            $this->Cell(17,10,$data->ID,1,0,'C');
            $this->Cell(40,10,$data->fname,1,0,'C');
            $this->Cell(30,10,$data->lname,1,0,'C');
            $this->Cell(30,10,$data->sex,1,0,'C');
            $this->Cell(18,10,$data->age,1,0,'C');
            $this->Cell(60,10,$data->email,1,0,'C');
            $this->Cell(45,10,$data->username,1,0,'C');
            $this->Cell(35,10,$data->contactnumber,1,0,'C');
            $this->Ln();
        }
    }
}
$pdf = new myPDF();
$pdf->SetFillColor(193,229,252);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->Output();
