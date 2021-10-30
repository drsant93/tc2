<?php if (isset($_SESSION['alerta'])) : ?>
    
    <script>
        alert("<?php echo $_SESSION['alerta']['mensagem'] ?>");
    </script>
    
    <!-- 
        <div class="alert alert-<?php echo $_SESSION['alerta']['tipo'] ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alerta']['mensagem'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    -->
    <?php unset($_SESSION['alerta']) ?>
<?php endif ?>