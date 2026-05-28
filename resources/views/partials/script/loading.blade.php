<div id="loading" class="loading text-center">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Chargement...</span>
    </div>
    <p>Chargement en cours...</p>
</div>
<style>
    .loading {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.027);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
</style>
<script>
    document.getElementById('formmm').addEventListener('submit', function(e) {
        document.getElementById('loading').style.display = 'flex';
        e.target.querySelector('button[type="submit"]').disabled = true;
    });
</script>
