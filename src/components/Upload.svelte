<script>
  import endpoints from "../js/endpoints";

  let showError = false;
  let showSuccess = false;
  let showImage = false;
  let disabled = false;
  let errorMsg="";
  let successMsg="";
  let src="";
  let submitBtnTxt = "Upload";
  const upload = (e)=>{
    submitBtnTxt = "Please wait...";
    disabled = true;
    const formdata = new FormData(e.target);
    if(formdata.get("upload").size === 0){
      showSuccess = false;
      showError = true;
      successMsg = "";
      errorMsg = "please upload file";
      submitBtnTxt = "Upload";
      disabled = false;
      return;
    }

    const option = {
      method : "post",
      body : formdata
    }

    ajax(endpoints.upload,option)
    .then((data)=>{
      submitBtnTxt = "Upload";
      disabled = false;
      if(!data.status){
        showImage = true;
        src = URL.createObjectURL(formdata.get("upload"));
        errorMsg = "";
        successMsg = data.msg;
        showSuccess = true;
        return;
      }

      successMsg = "";
      showSuccess = false;
      errorMsg = data.msg;
      showError = true;      
    })
    .catch((error)=>{
      submitBtnTxt = "Upload";
      disabled = false;
      successMsg = "";
      showSuccess = false;
      errorMsg = error;
      showError = true;
    });
  };

  const ajax = async (url,option) => {
    const response = await fetch(url,option);
    return response.json();
  };

</script>

<div class="upload-wrapper">
  <form enctype="multipart/form-data" id="upload-form" on:submit|preventDefault={upload}>
    <div class="upload-box">
      <input type="file" name="upload" class="upload-input">
      <div>
        <i class="fa fa-cloud-upload" style="font-size: 50px;color:#a2a2a2"></i>
        <h3>Drop File Here</h3>
      </div>
    </div>
    <button type="submit" class="submit-btn" {disabled} class:disabled={disabled}>{submitBtnTxt}</button>
  </form>

  {#if showError || showSuccess}
  <div class="error-notice" class:success={showSuccess}>
    <p style="font-weight: 600;">
      <i class="fa fa-exclamation-circle"></i>
      {errorMsg || successMsg}
    </p>
  </div>
  {/if}

  {#if showImage}
    <img {src} alt="img" width="400">
  {/if}

</div>

<style>
  #upload-form{
    width: 30%;
    margin: 0 auto;
  }

  .upload-box{
    width : 100%;
    height: 400px;
    background-color: #f5f5f5;
    border : 1px dashed #ccc;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .upload-input{
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
  }

  .submit-btn{
    width: 100%;
    background-color: chocolate;
    color : white;
    font-weight: 600;
    border : none;
    padding : 10px;
    margin-top: 20px;
  }

  .disabled{
    background-color: #e8b28c;
  }

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