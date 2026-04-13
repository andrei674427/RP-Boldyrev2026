<?php 
include "includes/header.php"; 
include "includes/db.php"; 
?>
<link rel="stylesheet" href="css/style.css">

<section class="page">
    <h1>Все сезоны</h1>

    <?php
    // Базовая папка в вашем проекте RP
    $baseDir = "videos"; 
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $baseDir;

    if (is_dir($fullPath)):
        // 1. Получаем список всех папок сезонов (S1, S2, S3)
        $seasons = array_filter(scandir($fullPath), function($item) use ($fullPath) {
            return is_dir($fullPath . '/' . $item) && !in_array($item, ['.', '..']);
        });

        natsort($seasons); // Сортировка по порядку: 1, 2, 3

        foreach ($seasons as $seasonFolderName):
            $seasonPath = $fullPath . '/' . $seasonFolderName;
            
            // 2. Загружаем описания для этого конкретного сезона
            $descriptions = [];
            $descFile = $seasonPath . '/descriptions.txt';
            if (file_exists($descFile)) {
                $lines = file($descFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    // Формат файла: S1E01=Текст описания
                    if (strpos($line, '=') !== false) {
                        list($fName, $text) = explode('=', $line, 2);
                        $descriptions[trim($fName)] = trim($text);
                    }
                }
            }

            // 3. Ищем видеофайлы .mp4 в папке сезона
            $episodes = array_filter(scandir($seasonPath), function($file) {
                return strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'mp4';
            });

            natsort($episodes);

            if (!empty($episodes)): 
                // Превращаем "S1" в "Сезон 1" для заголовка
                $displayTitle = str_replace('S', 'Сезон ', $seasonFolderName);
            ?>
                <div class="season-wrapper" style="margin-bottom: 60px;">
                    <h2 style="color: #ffd700; border-bottom: 2px solid #444; padding-bottom: 10px; margin-bottom: 25px;">
                        <?= htmlspecialchars($displayTitle) ?>
                    </h2>
                    
                    <div class="trailers-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
                        <?php foreach ($episodes as $videoFile): 
                            $cleanName = pathinfo($videoFile, PATHINFO_FILENAME); // Получим "S1E01"
                            $videoSrc = "/" . $baseDir . "/" . rawurlencode($seasonFolderName) . "/" . rawurlencode($videoFile);
                            $currentDesc = $descriptions[$cleanName] ?? "Описание скоро появится...";
                        ?>
                            <div class="episode-card" style="background: #1a1a1a; padding: 15px; border-radius: 12px; transition: 0.3s;">
                                <h3 style="color: #fff; font-size: 1.1rem; margin-bottom: 12px;">Серия <?= htmlspecialchars($cleanName) ?></h3>
                                
                                <video controls style="width: 100%; border-radius: 6px; aspect-ratio: 16/9; background: #000;">
                                    <source src="<?= $videoSrc ?>" type="video/mp4">
                                    Ваш браузер не поддерживает видео.
                                </video>

                                <div class="desc-text" style="margin-top: 15px; color: #aaa; font-size: 0.85rem; line-height: 1.4;">
                                    <p><?= htmlspecialchars($currentDesc) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php 
            endif; 
        endforeach; 
    else:
        echo "<p style='color: red;'>Папка $baseDir не найдена в корне проекта.</p>";
    endif;
    ?>
</section>

<?php include "includes/footer.php"; ?> 