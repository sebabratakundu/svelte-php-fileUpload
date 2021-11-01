<script>
  export let success =false;
  export let msg;
</script>

<div class="error-notice" class:success={success}>
  <p style="font-weight: 600;">
    <i class="fa fa-exclamation-circle"></i>
    {msg}
  </p>
</div>

<style>
  .error-notice{
    width: 30%;
    margin: 0 auto;
    background-color: #FFF5F8;
    color: #F1416C;
    padding : 10px 0;
    padding-left: 20px;
    text-align: left;
    margin-top: 20px;
    border-left: 4px solid #F1416C;
  }

  .success{
    background-color: #E8FFF3 !important;
    color: #5AD8D1 !important;
    border-left: 4px solid #5AD8D1;
  }
</style>
