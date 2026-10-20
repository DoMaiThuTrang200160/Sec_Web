<style>
    .upload-container {
        max-width: 650px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 10px auto;
        color: #404040;
    }
    .upload-container h3 {
        margin-top: 0;
        margin-bottom: 15px;
        padding-bottom: 8px;
        color: #5B8798;
        font-size: 20px;
        text-align: center;
        border-bottom: 1px solid #D6E0DC;
    }
    .upload-container>p {
        margin: 0 0 20px 0;
        color: #6F7775;
        font-size: 14px;
        text-align: center;
    }
    .file-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin: 20px 0;
    }
    .file-item {
        background: #F6F8F6;
        padding: 12px;
        border: 1px solid #D6E0DC;
        border-radius: 6px;
        font-size: 14px;
    }
    .file-item label {
        display: block;
        margin-bottom: 7px;
        color: #345D6B;
        font-weight: bold;
    }
    .file-item input[type="file"] {
        width: 100%;
        box-sizing: border-box;
        font-family: "Times New Roman", serif;
        font-size: 13px;
        color: #404040;
    }
    .btn-submit {
        display: block;
        margin: 20px auto 0;
        background-color: #5B8798;
        color: #FFFFFF;
        border: 1px solid #5B8798;
        padding: 9px 22px;
        border-radius: 5px;
        cursor: pointer;
        font-family: "Times New Roman", serif;
        font-weight: bold;
        font-size: 14px;
        transition: 0.3s;
    }
    .btn-submit:hover {
        background-color: #345D6B;
        border-color: #345D6B;
    }
    @media (max-width: 600px) {
        .file-list {
            grid-template-columns: 1fr;
        }
        .upload-container {
            padding: 18px;
        }
    }
</style>
<div class="upload-container">
    <h3>Upload nhiều file sử dụng mảng kết hợp</h3>
    <p><i>(Upload tối đa 10 file, in danh sách tên file và đường dẫn download sau khi upload)</i></p>
    <form method="POST" action="index.php?page=uploadprocess" enctype="multipart/form-data">
        <div class="file-list">
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <div class="file-item">
                    <label for="file_<?php echo $i; ?>">File <?php echo $i; ?>:</label>
                    <input type="file" id="file_<?php echo $i; ?>" name="files[]">
                </div>
            <?php endfor; ?>
        </div>
        <button type="submit" name="submit" class="btn-submit">Upload Files</button>
    </form>
</div>
<?php
for ($i = 0; $i < 10; $i++) { }
?>