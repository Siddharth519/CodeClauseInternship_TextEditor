<!DOCTYPE html>
<html>
<head>
    <title>Text Editor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            padding: 0;
        }

        #container {
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 10px solid #ccc;
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            color: black;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        input[type="file"],
        .tab-button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        input[type="file"]:hover,
        .tab-button:hover {
            background-color: #0056b3;
        }

        input[type="file"] {
            display: none;
        }

        .tab-button {
            font-size: 16px;
        }

        textarea {
            width: 100%;
            height: 400px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
            font-size: 2rem;
        }

        #characterCount {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
            text-align: right; /* Align to the right */
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>Text Editor</h1>
        <form method="post">
            <div class="button-container">
                <label for="fileInput" class="tab-button">Open File</label>
                <input type="file" id="fileInput" style="display: none;">
                <button class="tab-button" id="downloadButton">Download</button>
                <button class="tab-button" id="printButton">Print</button>
            </div>
            <textarea id="editor" name="content" rows="10"></textarea>
            <div id="characterCount">Characters: 0</div>
        </form>
    </div>
    
    <script>
        const editor = document.getElementById('editor');
        const characterCount = document.getElementById('characterCount');
        const fileInput = document.getElementById('fileInput');
        const downloadButton = document.getElementById('downloadButton');
        const printButton = document.getElementById('printButton');

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                const content = e.target.result;
                editor.value = content;
                updateCharacterCount(content);
            };
            reader.readAsText(file);
        });

        editor.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'copy';
        });

        editor.addEventListener('drop', (e) => {
            e.preventDefault();
            const file = e.dataTransfer.files[0];
            const reader = new FileReader();
            reader.onload = function (event) {
                const content = event.target.result;
                editor.value = content;
                updateCharacterCount(content);
            };
            reader.readAsText(file);
        });

        editor.addEventListener('input', () => {
            updateCharacterCount(editor.value);
        });

        downloadButton.addEventListener('click', () => {
            const content = editor.value;
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `text_editor_${Date.now()}.txt`;
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            URL.revokeObjectURL(url);
            document.body.removeChild(a);
        });

        printButton.addEventListener('click', () => {
            const content = editor.value;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`<pre>${content}</pre>`);
            printWindow.print();
            printWindow.close();
        });

        function updateCharacterCount(text) {
            const count = text.length;
            characterCount.textContent = `Characters: ${count}`;
        }
    </script>
</body>
</html>
