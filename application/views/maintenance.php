<!DOCTYPE HTML>
<html lang="en">
<head>
    <title><?php echo $this->general_settings->maintenance_mode_title; ?> - <?php echo $this->general_settings->application_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400&display=swap" rel="stylesheet">

    <style>
        html {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
            font-weight: 400;
            word-wrap: break-word;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .site-title {
            position: absolute;
            top: 100px;
            left: 0;
            right: 0;
            font-size: 96px;
            font-weight: 400;
        }

        .title {
            font-size: 48px;
            line-height: 52px;
        }

        .description {
            max-width: 560px;
            margin: 0 auto;
            font-size: 20px;
            line-height: 28px;
        }

        .maintenance {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            background-size: cover;
            background-image: url('<?php echo base_url(); ?>assets/img/maintenance_bg.jpg');
            z-index: 1;
        }

        .maintenance:after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: -20;
            opacity: .72;

            background: #1F1C2C; /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #928DAB, #1F1C2C); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #928DAB, #1F1C2C); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


        }

        .maintenance-inner {
            display: table;
            height: 100%;
            width: 100%;
        }

        .maintenance-inner .content {
            display: table-cell;
            vertical-align: middle;
            padding: 20px;
        }

        @media (max-width: 991px) {
            .site-title {
                font-size: 64px;
                position: relative;
                top: -60px;
            }
        }
    </style>

</head>
<body>

<div class="maintenance">
    <div class="maintenance-inner">
        <div class="content">
            <h1 class="site-title"><?php echo $this->general_settings->application_name; ?></h1>
            <h2 class="title"><?php echo $this->general_settings->maintenance_mode_title; ?></h2>
            <p class="description"><?php echo $this->general_settings->maintenance_mode_description; ?></p>
        </div>
    </div>
</div>

</body>
</html>

<?php exit(); ?>
