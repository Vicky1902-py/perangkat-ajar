<script type="text/php">
    if (isset($pdf)) {
        $font = $fontMetrics->get_font("Helvetica", "normal");
        $size = 7.5;
        $color = array(0.35, 0.35, 0.35);
        $w = $pdf->get_width();
        $h = $pdf->get_height();
        
        // Garis pemisah halus di atas footer
        $pdf->line(35, $h - 28, $w - 35, $h - 28, array(0.82, 0.82, 0.82), 0.6);

        // Hak Cipta resmi di sebelah kiri
        $textLeft = "Hak Cipta : Desain by. Vicky Koroh";
        $pdf->text(35, $h - 21, $textLeft, $font, $size, $color);
        
        // Nomor halaman dinamis di sebelah kanan
        $textRight = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
        $pdf->page_text($w - 130, $h - 21, $textRight, $font, $size, $color);
    }
</script>
