<?php
function encryptText($text, $key) {
    $encryptedText = '';
    $keyLength = strlen($key);
    
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $shift = 0; // Set default shift untuk karakter non-alphabet
        
        if (ctype_alpha($char)) {
            $shift = ord(strtolower($key[$i % $keyLength])) - ord('a');
            $isUpperCase = ctype_upper($char);
            $char = strtolower($char);
            $position = ord($char) - ord('a');
            $newPosition = ($position + $shift) % 26;
            $newChar = chr($newPosition + ord('a'));
            
            if ($isUpperCase) {
                $newChar = strtoupper($newChar);
            }
        } else {
            $newChar = $char; // Karakter non-alphabet tidak diubah
        }
        
        $encryptedText .= $newChar;
    }
    
    return $encryptedText;
}

function decryptText($text, $key) {
    $decryptedText = '';
    $keyLength = strlen($key);
    
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $shift = 0; 
        
        if (ctype_alpha($char)) {
            $shift = ord(strtolower($key[$i % $keyLength])) - ord('a');
            $isUpperCase = ctype_upper($char);
            $char = strtolower($char);
            $position = ord($char) - ord('a');
            $newPosition = ($position - $shift + 26) % 26;
            $newChar = chr($newPosition + ord('a'));
            
            if ($isUpperCase) {
                $newChar = strtoupper($newChar);
            }
        } else {
            $newChar = $char; 
        }
        
        $decryptedText .= $newChar;
    }
    
    return $decryptedText;
}




$text = ''; // Masukkan teks yang ingin dienkripsi/didekripsi di sini
$key = 'WAHYU'; // Kunci enkripsi

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["text"])) {
    $text = $_POST["text"];
    if (isset($_POST["operation"]) && $_POST["operation"] == "encrypt") {
        $encryptedText = encryptText($text, $key);
    } elseif (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") {
        $decryptedText = decryptText($text, $key);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enkripsi dan Dekripsi Teks</title>
</head>
<body>
    <h1>Enkripsi dan Dekripsi Teks Menggunakan Vigenere Cipher</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="text">Masukkan teks:</label>
        <input type="text" name="text" id="text" value="<?php echo $text; ?>">
        <input type="radio" name="operation" value="encrypt" <?php if (!isset($_POST["operation"]) || (isset($_POST["operation"]) && $_POST["operation"] == "encrypt")) echo "checked"; ?>> Enkripsi
        <input type="radio" name="operation" value="decrypt" <?php if (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") echo "checked"; ?>> Dekripsi
        <input type="submit" value="Proses">
    </form>

    <?php if (!empty($encryptedText) || !empty($decryptedText)): ?>
        <?php if (isset($_POST["operation"]) && $_POST["operation"] == "encrypt"): ?>
            <h2>Hasil Enkripsi</h2>
        <?php elseif (isset($_POST["operation"]) && $_POST["operation"] == "decrypt"): ?>
            <h2>Hasil Dekripsi</h2>
        <?php endif; ?>
        <p>Input: <?php echo $text; ?></p>
        <p>Output: <?php echo (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") ? $decryptedText : $encryptedText; ?></p>
    <?php endif; ?>

    <a href="index.php"><button>Enskripsi Tahap Pertama</button></a>
</body>
</html>
