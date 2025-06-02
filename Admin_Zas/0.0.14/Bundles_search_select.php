<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Product Search</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9fafb;
            margin: 40px;
            color: #222;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        form {
            max-width: 600px;
            margin: 0 auto 40px;
            display: flex;
        }
        input[type="text"] {
            flex-grow: 1;
            padding: 12px 15px;
            font-size: 16px;
            border-radius: 6px 0 0 6px;
            border: 1px solid #ccc;
            border-right: none;
            outline: none;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus {
            border-color: #007bff;
        }
        input[type="submit"] {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #007bff;
            border: none;
            border-radius: 0 6px 6px 0;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        thead {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }
        th, td {
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #e3e6eb;
        }
        tr:hover {
            background-color:rgb(179, 175, 244);
        }
        button {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1e7e34;
        }
        p.message {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            background-color: #ffdddd;
            border: 1px solid #ff5c5c;
            color: #a60000;
            font-weight: 600;
            border-radius: 6px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Product Search</h1>

    <form method="GET" action="">
        <input
            type="text"
            name="query"
            placeholder="Search products by name, category, manufacturer, or UID..."
            value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>"
            onkeyup="debouncedFetch(this.value)"
            autocomplete="off"
            required
        />
        <input type="submit" value="Search" />
    </form>

    <div id="resultsContainer">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["query"]) && !isset($_GET["ajax"])) {
            include 'search_logic.php';
        }
        ?>
    </div>

    <script>
        function selectProduct(productName, uid) {
            alert("Selected product:\nName: " + productName + "\nUID: " + uid);
        }

        const resultsContainer = document.getElementById('resultsContainer');

        function fetchResults(query) {
            if (!query.trim()) {
                resultsContainer.innerHTML = '<p style="text-align:center; color:#555;">Start typing to search products...</p>';
                return;
            }

           fetch(`Bundles_Search_Logic.php?ajax=1&query=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(html => {
                    resultsContainer.innerHTML = html;
                })
                .catch(error => {
                    resultsContainer.innerHTML = '<p class="message">Error fetching results. Please try again.</p>';
                    console.error('Fetch error:', error);
                });
        }

        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        const debouncedFetch = debounce(fetchResults, 300);

        window.addEventListener("DOMContentLoaded", function () {
            const initialQuery = "<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>";
            if (initialQuery) {
                fetchResults(initialQuery);
            }
        });
    </script>
</body>
</html>
