<? if ($result['id_page'] == 14) { ?>
    <img src="/files/img/banner_id_14.jpg" alt="">
<? } ?>

<? if ($result) { ?>
    <div class="container page">
        <h1 class="page-title"><? echo $result['name']; ?></h1>
        <? echo $result['text']; ?>
    </div>
<? } ?>


<div class="container">
    <div class="album-public-area">
        <div class="album-public-item">
            <?
            foreach ($album as $item) {
                $imageBase64 = base64_encode($item["image"]);
                echo '<img width="365px" class="album-public-image" src="data:image/jpeg;base64,' . $imageBase64 . '" />';
            }
            ?>
        </div>
    </div>
</div>

<div class="container" style="padding-bottom: 50px;">
    
    <?
    if(!empty($document)){
        echo '<h3>Прикрепленные файлы</h3>';

        foreach ($document as $item) {
            echo '<li><a href="' . 'admin/site/docs/' . $item['filename'] . '" style="color:#3366BB ; font-size:14px">' . $item['name'] . '</a></li>';
        }
    }
    ?>
</div>