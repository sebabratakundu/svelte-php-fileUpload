<script>
  import endpoints from "../js/endpoints";
  import Alert from "./Alert.svelte";
  let showError = false;
  let msg ="";
  let formdata;
  let isSubmited = false;
  const upload = async (e)=>{
    formdata = new FormData(e.target);
    if(formdata.get("upload").size === 0){
      showError = true;
      msg = "please upload file";
      return;
    }
    isSubmited = true;
    showError = false;
  };

  const ajax = async () => {
    const response = await fetch(endpoints.upload,{
      method : "POST",
      body : formdata
    });
    const result =  await response.json();
    return result;
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

    {#if isSubmited}
    {#await ajax()}
    <button type="submit" class="submit-btn disabled" disabled>Please wait...</button>
    {:then data} 
      <button type="submit" class="submit-btn">Upload</button>
      {#if !data.status}
      <Alert msg={data.msg} success={true} /> 
      <img src={URL.createObjectURL(formdata.get("upload"))} alt="img" width="400">
      {:else}
      <Alert msg={data.msg} />
      {/if}
    {:catch error}
    <Alert msg={error.msg} />  
    {/await}
    {:else}
    <button type="submit" class="submit-btn">Upload</button>      
    {/if}
  </form>

  {#if showError}
  <Alert {msg} />
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
</style>
