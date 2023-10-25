<?php
// Tabel substitusi karakter
$encryptionTable = [
    'A' => 'W',
    'B' => 'A',
    'C' => 'H',
    'D' => 'Y',
    'E' => 'U',
    'F' => 'B',
    'G' => 'C',
    'H' => 'D',
    'I' => 'E',
    'J' => 'F',
    'K' => 'G',
    'L' => 'I',
    'M' => 'J',
    'N' => 'K',
    'O' => 'L',
    'P' => 'M',
    'Q' => 'N',
    'R' => 'O',
    'S' => 'P',
    'T' => 'Q',
    'U' => 'R',
    'V' => 'S',
    'W' => 'T',
    'X' => 'V',
    'Y' => 'X',
    'Z' => 'Z'
];

// Fungsi untuk mengenkripsi teks
function encryptText($text, $table) {
    $encryptedText = "";
    $text = strtoupper($text); 

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (array_key_exists($char, $table)) {
            $encryptedText .= $table[$char];
        } else {
            $encryptedText .= $char;
        }
    }

    return $encryptedText;
}

// Fungsi untuk mendekripsi teks
function decryptText($text, $table) {
    $decryptedText = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $originalChar = array_search($char, $table);
        if ($originalChar !== false) {
            $decryptedText .= $originalChar;
        } else {
            $decryptedText .= $char;
        }
    }

    return $decryptedText;
}

// Inisialisasi variabel
$text = "";
$processedText = "";
$operation = "encrypt"; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST["text"];
    $operation = $_POST["operation"];

    if ($operation == "encrypt") {
        $processedText = encryptText($text, $encryptionTable);
    } elseif ($operation == "decrypt") {
        $processedText = decryptText($text, $encryptionTable);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enkripsi dan Dekripsi Teks</title>
</head>
<body>
    <h1>Enkripsi dan Dekripsi Teks Menggunakan Caesar Chiper</h1>
    <form method="post" action="">
        <label for="text">Masukkan Teks:</label>
        <input type="text" id="text" name="text" value="<?php echo $text; ?>">
        
        <!-- Tambahkan radio button untuk memilih enkripsi atau dekripsi -->
        <input type="radio" name="operation" value="encrypt" <?php if ($operation == "encrypt") echo "checked"; ?>> Enkripsi
        <input type="radio" name="operation" value="decrypt" <?php if ($operation == "decrypt") echo "checked"; ?>> Dekripsi

        <input type="submit" value="Proses">
    </form>

    <?php if (!empty($processedText)) : ?>
        <?php if ($operation == "encrypt") : ?>
            <h2>Hasil Enkripsi:</h2>
        <?php elseif ($operation == "decrypt") : ?>
            <h2>Hasil Dekripsi:</h2>
        <?php endif; ?>
        <p><?php echo $processedText; ?></p>
    <?php endif; ?>

    <a href="index2.php"><button>Enkripsi Tahap Kedua</button></a>
</body>
</html>
