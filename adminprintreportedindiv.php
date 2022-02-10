<?php
require "FPDF/fpdf.php";
$db = new PDO('mysql:host=localhost;dbname=academx_db','root','');


class myPDF extends FPDF{
    function header(){
        
        $this->Image('img/tablogo.png',69,7);
        $this->SetFont('Arial', 'B',25);
        $this->Cell(276,24, 'ACADEMX REPORT LIST',0,0,'C');
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
        $this->Cell(30,10,'Report ID',1,0,'C',true);
        $this->Cell(40,10,'Post ID',1,0,'C',true);
        $this->Cell(60,10,'Reason',1,0,'C',true);
        $this->Cell(36,10,'Reported By ID',1,0,'C',true);
        $this->Cell(60,10,'Report Date',1,0,'C',true);
        $this->Cell(47,10,'Poster ID',1,0,'C',true);
        $this->Ln();
    }
    function viewTable($db){
        $this->SetFont('Times','',12);
        $ID=$_GET['token'];
        $stmt = $db->query("select * from amx_report_tbl where report_ID = '$ID'");
        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
            $this->SetFillColor(63,63,63);
            $this->SetFont('arial','',12);
            $this->Cell(30,10,$data->report_ID,1,0,'C');
            $this->Cell(40,10,$data->post_id,1,0,'C');
            $this->Cell(60,10,$data->reason_content,1,0,'C');
            $this->Cell(36,10,$data->reported_by,1,0,'C');
            $this->Cell(60,10,$data->report_date,1,0,'C');
            $this->Cell(47,10,$data->poster_ID,1,0,'C');
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
$pdf->Output("I");
