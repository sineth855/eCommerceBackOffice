<template>
  <div id="page-text-fields">
    <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="onSubmit">
      <!--Bread Camp for form -->
      <bread-crumb
        :routeName="routeName"
        :parent_name="parent_name"
        :child_name="child_name">
      </bread-crumb>
      <!--#End Bread Camp for form -->

      <v-container grid-list-xl fluid>
        <!--toast message-->
        <message
          ref="child"
          :notifyStatus="notifyStatus"
          :message="message" > 
        ></message>
        <!--#End toast message-->
        <v-layout row wrap>
          <v-flex sm12>
            <v-widget :title="child_name" >
              <div slot="widget-content">
                <v-container>
                  
                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Image</v-subheader>
                    </v-flex>
                    <v-flex xs2>
                      <div class="box">
                        <input name="image" type="file" id="fileInput"  style="display:none" ref="fileInput" accept="image/*" @change="showPreviewMainImage($event)"/>
                        
                        <label for="fileInput">
                          <v-card>
                            <v-badge color="red" overlap style="font-size:10px;position:absolute;left:0;">
                              <v-btn small @click="clearMainImage()">
                                Remove
                              </v-btn>
                            </v-badge>
                            <img width="100%" :alt="formData.name" class="image" :src="imagePreview"/>
                            <input type="hidden" v-model="formData.image"/>
                          </v-card>
                        </label>
                        <!--<input type="file" accept="image/*" name="fileupload" v-on:change="showPreviewImage($event)" id="file-5" class="inputfile inputfile-4" data-multiple-caption="{count} files selected" />
                        <label for="file-5"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span>Choose a file&hellip;</span></label>
                        <span v-if="imagePreview.length > 0">
                          <img width="100px" :src="imagePreview"/><br/>
                        </span>-->
                      </div>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Name *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Name"
                        name="name"
                        placeholder="Name"
                        v-model="formData.name"
                        v-validate="'required'"
                        data-vv-name="name"     
                        :error-messages="errors.collect('name')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Sort Order</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Sort Order"
                        name="name"
                        placeholder="Sort Order"
                        v-model="formData.sort_order"
                        data-vv-name="sort_order"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>
         
                </v-container>
              </div>
            </v-widget>
          </v-flex>
        </v-layout>
      </v-container>
    </v-form>

  </div>
</template>

<script>
  import * as $ from 'jquery';
  import {uploadFile} from '~/services/fileUpload';
  import {createData,editData,updateData} from '~/api/catalog/manufacturer'
  import Message from '~/components/common/Message'
  import BreadCrumb from '~/components/common/BreadCrumb'
  import VWidget from '~/components/VWidget';
  import Flash from '~/services/flash'
  export default {
    props:['id'],
    $_veeValidate: {
      validator: 'new'
    },
    components: {
      VWidget,
      Message,
      BreadCrumb
    },
    data () {
      return {
        parent_name:'Manufacturer',
        child_name:'Manufacturer Form',
        routeName:'Manufacturer',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        imagePreview: './img/NoPicture.png',
        formData: {
          image: '',
          name: '',
          sort_order: 0
        },
        attributeGroup: [],
      };
    },
    computed: {
    }, 
    created() {
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
    },
    methods: {
      clearMainImage(){
        this.imagePreview = './img/NoPicture.png';
        $('.image').attr('src', this.imagePreview);
        this.formData.image = '';
        // this.$refs.fileInput = './img/NoPicture.png';
      },
      // Upload Image 
      showPreviewMainImage(event) {
        
        this.formData.hidden_image = ''
        const form = event.target;
        const file = event.target.files[0];
        const fd = new FormData();
        fd.append('image', file);
        // Reference to the DOM input element
        var input = event.target;
        // Ensure that you have a file before attempting to read it
        if (input.files && input.files[0]) {
            // create a new FileReader to read this image and convert to base64 format
            var reader = new FileReader();
            // Define a callback function to run, when FileReader finishes its job
            reader.onload = (e) => {
                // Note: arrow function used here, so that "this.imagePreview" refers to the imageData of Vue component
                // Read image as base64 and set to imageData
                // this.imagePreview = e.target.result;
                $('.image').attr('src', e.target.result);
                uploadFile(fd).then(response => {
                  if(response.success == true){
                    // create data
                    this.formData.image = response.data.image_url
                  }else{
                    alert("Error while trying to upload file!")
                  }
                }).catch(e => {
                    alert("Error while trying to upload file!")
                    // this.errors.push(e)
                });
            }
            // Start the reader job - read file as a data url (base64 format)
            reader.readAsDataURL(input.files[0]);
        }
      },
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.image = response['data']['image'];
          this.imagePreview = response['data']['image'];
          this.formData.name = response['data']['image']
          this.formData.name = response['data']['name']
          this.formData.sort_order = response['data']['sort_order']
          Flash.setLoading(false)
        })
      },
      clear () {
        this.formData = {};
        this.$validator.reset();
      },
      onSubmit () {
        this.$validator.validateAll().then((result) => {
        if(!result){
          this.notifyStatus = 'error';
          this.message = 'All fields are required!';
          return false;
        }
          // If has props edit data
          if(this.id){
            updateData(this.formData,this.id).then(response => {
              if(response.success == true){
                this.notifyStatus = 'success'
                this.message = response.message
              }else{
                this.notifyStatus = 'error'
                this.message = response.message
              }
            }).catch(e => {
                this.notifyStatus = 'error'
                this.message = 'Error while trying to update data!'
            })
          }else{        
            createData(this.formData).then(response => {
              if(response.success == true){
                this.notifyStatus = 'success'
                this.message = response.message
                this.clear()
              }else{
                this.notifyStatus = 'error'
                this.message = response.message
              }
            }).catch(e => {
                this.notifyStatus = 'error'
                this.message = 'Error while trying to create data!'
            })
          }
        }).catch(() => {
        });
        
      }
    }
  };
</script>