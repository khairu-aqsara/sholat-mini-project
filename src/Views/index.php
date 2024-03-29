<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>PRAYING TIME</title>
    <?php if(!is_null($data)):?>
        <meta http-equiv="refresh" content="<?php echo (!$time_to_pray) ? 2 : 240 ;?>">
    <?php endif;?>
</head>
<body>
    <div class="h-screen w-screen flex justify-center items-center">
        <div class="2xl:w-4/12 lg:w-8/12 md:w-8/12 shadow-md flex items-center justify-center p-4 rounded-md <?php echo (!$time_to_pray) ? "bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90%" : "bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500";?>">
            <?php if(!is_null($data)):?>
                <?php if($time_to_pray):?>
                <audio controls autoplay id="adzan" class="hidden">
                    <source src="voice.mp3" type="audio/mpeg">
                </audio>
                <?php endif;?>
                <?php foreach($data as $rs):?>
                    <div class="flex flex-col justify-center items-center px-3">
                        <div class="text-slate-50 uppercase font-bold"><?php echo $rs->praying_name;?></div>
                        <div class="text-slate-200 font-bold tracking-tight text-sm"><?php echo $rs->praying_time;?></div>
                    </div>
                <?php endforeach;?>
            <?php else:?>
                <div class="flex flex-col justify-center items-center">
                    <h3 class="text-slate-50 uppercase font-bold text-lg">WELCOME</h3>
                    <div class="text-slate-50 uppercase font-bold">please select your box</div>
                </div>
            <?php endif;?>
        </div>
    </div>
</body>
</html>