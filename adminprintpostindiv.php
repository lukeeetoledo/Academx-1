<?php
require "FPDF/fpdf.php";
$db = new PDO('mysql:host=localhost;dbname=academx_db','root','');


class myPDF extends FPDF{
    function header(){
        
        $this->Image('img/tablogo.png',69,7);
        $this->SetFont('Arial', 'B',25);
        $this->Cell(276,24, 'ACADEMX POST LIST',0,0,'C');
        $this->Ln(20);
        $this->SetFont('arial','',12);
        $this->Cell(276,0, 'Compilation of posts in AcadeMx',0,0,'C');
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
        $this->Cell(30,10,'Post ID',1,0,'C',true);
        $this->Cell(40,10,'Post Title',1,0,'C',true);
        $this->Cell(30,10,'User Id',1,0,'C',true);
        $this->Cell(36,10,'Post Type',1,0,'C',true);
        $this->Cell(30,10,'Post Group',1,0,'C',true);
        $this->Cell(47,10,'Post Date',1,0,'C',true);
        $this->Cell(35,10,'Like amount',1,0,'C',true);
        $this->Cell(35,10,'Dislike Amount',1,0,'C',true);
        $this->Ln();
    }
    function viewTable($db){
        $this->SetFont('Times','',12);
        $ID=$_GET['token'];
        $stmt = $db->query("select * from amx_post_tbl where post_id = '$ID'");
        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
            $this->SetFillColor(63,63,63);
            $this->SetFont('arial','',12);
            $this->Cell(30,10,$data->post_id,1,0,'C');
            $this->Cell(40,10,$data->post_title,1,0,'C');
            $this->Cell(30,10,$data->userid,1,0,'C');
            $this->Cell(36,10,$data->post_type,1,0,'C');
            $this->Cell(30,10,$data->post_group,1,0,'C');
            $this->Cell(47,10,$data->post_date,1,0,'C');
            $this->Cell(35,10,$data->like_amount,1,0,'C');
            $this->Cell(35,10,$data->dislike_amount,1,0,'C');
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
