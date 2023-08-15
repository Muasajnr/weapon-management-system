<?php
    switch($doc_ext):
        case 'pdf':
            echo "<embed src=\"".site_url($doc_media)."\" type=\"application/pdf\" width=\"800\" height=\"1200\">";
            break;
        case 'jpeg':
        case 'jpg':
        case 'png':
            echo "<img src=\"".site_url($doc_media)."\" alt=\"$doc_name\">";
            break;
        default:
            echo "<p>Terjadi kesalahan!</p>";
            break;
    endswitch;
?>