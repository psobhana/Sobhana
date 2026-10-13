<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empty HTML Page with Theme Button and SVG Icon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            transition: background-color 0.3s;
        }
        .button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .light-theme {
            background-color: #ffffff;
            border: 1px solid #ccc;
            color: #000000;
        }
        .dark-theme {
            background-color: #333333;
            border: 1px solid #555555;
            color: #ffffff;
        }
        .icon {
            width: 50px;
            height: 50px;
            transition: fill 0.3s;
        }
    </style>
</head>
<body>
    <button id="themeButton" class="button light-theme">Switch to Dark Theme</button>
    <svg class="icon light-theme" viewBox="0 0 24 24">
        <path d="M12 2L2 22h20L12 2z"/>
    </svg>

    <script>
        const button = document.getElementById('themeButton');
        let isDarkTheme = false;

        button.addEventListener('click', () => {
            if (isDarkTheme) {
                document.body.classList.remove('dark-theme');
                document.body.classList.add('light-theme');
                button.classList.remove('dark-theme');
                button.classList.add('light-theme');
                button.textContent = 'Switch to Dark Theme';
                document.querySelector('.icon').setAttribute('fill', '#000000');
                isDarkTheme = false;
            } else {
                document.body.classList.remove('light-theme');
                document.body.classList.add('dark-theme');
                button.classList.remove('light-theme');
                button.classList.add('dark-theme');
                button.textContent = 'Switch to Light Theme';
                document.querySelector('.icon').setAttribute('fill', '#ffffff');
                isDarkTheme = true;
            }
        });
    </script>

    <style>
        .light-theme {
            background-color: #ffffff;
        }
        .dark-theme {
            background-color: #333333;
        }
    </style>
</body>
</html>
