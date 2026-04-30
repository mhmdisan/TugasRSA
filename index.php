<?php
function xorCipher($data, $key) {
    $output = '';
    for ($i = 0; $i < strlen($data); $i++) {
        $output .= chr(ord($data[$i]) ^ ord($key[$i % strlen($key)]));
    }
    return $output;
}

$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $text = $_POST['text'] ?? '';
    $key = $_POST['key'] ?? '';
    $action = $_POST['action'] ?? '';

    if ($action == 'encrypt') {
        $encrypted = xorCipher($text, $key);
        $result = bin2hex($encrypted);
    } elseif ($action == 'decrypt') {
        $text = hex2bin($text);
        $result = xorCipher($text, $key);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>XOR Crypto App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-500 to-indigo-600 min-h-screen flex items-center justify-center">

<div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-lg">

    <h1 class="text-2xl font-bold text-center text-gray-700 mb-6">
        🔐 Enkripsi & Dekripsi XOR
    </h1>

    <form method="POST" class="space-y-4">

        <div>
            <label class="block text-sm font-semibold text-gray-600">
                Masukkan Pesan
            </label>
            <input type="text" name="text" required
                value="<?= isset($_POST['text']) ? $_POST['text'] : '' ?>"
                class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-600">
                Kata Kunci (Key)
            </label>
            <input type="text" name="key" required
                value="<?= isset($_POST['key']) ? $_POST['key'] : '' ?>"
                class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-600">
                Pilih Aksi
            </label>
            <select name="action"
                class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none">
                <option value="encrypt">Enkripsi (Plain → Cipher)</option>
                <option value="decrypt">Dekripsi (Cipher → Plain)</option>
            </select>
        </div>

        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold p-3 rounded-xl transition duration-300">
            Proses Kriptografi
        </button>
    </form>

    <?php if ($result): ?>
        <div class="mt-6 bg-gray-100 p-4 rounded-xl">
            <h2 class="text-lg font-semibold text-gray-700">Hasil:</h2>
            <p class="mt-2 text-gray-800 break-words"><?= htmlspecialchars($result) ?></p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>