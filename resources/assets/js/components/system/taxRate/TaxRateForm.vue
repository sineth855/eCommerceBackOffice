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
                      <v-subheader>Geo Zone *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-select
                        :items="geoZone"
                        v-model="formData.geo_zone_id"
                        label="GEO Zone"
                        auto
                        required
                        item-text="name"
                        item-value="id"
                        v-validate="'required'"
                        data-vv-name="GEO Zone"     
                        :error-messages="errors.collect('GEO Zone')"  
                      ></v-select>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Customer Group *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-select
                        :items="customerGroup"
                        v-model="formData.customer_group_id"
                        label="Customer Group"
                        auto
                        required
                        item-text="name"
                        item-value="id"
                        v-validate="'required'"
                        data-vv-name="customer group"     
                        :error-messages="errors.collect('customer group')"  
                      ></v-select>
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
                      <v-subheader>Rate *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Rate"
                        name="rate"
                        type="number"
                        placeholder="Rate"
                        v-model="formData.rate"
                        v-validate="'required'"
                        data-vv-name="rate"     
                        :error-messages="errors.collect('rate')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Type *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Type"
                        maxlength="1"
                        name="type"
                        placeholder="Type"
                        v-model="formData.type"
                        v-validate="'required'"
                        data-vv-name="type"     
                        :error-messages="errors.collect('type')"  
                        required
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
  import {createData,editData,updateData} from '~/api/system/taxRate'
  import {fetchGeoZoneList} from '~/api/system/geoZone'
  import {fetchCustomerGroupList} from '~/api/customer/customerGroup'
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
        parent_name:'Tax Rate',
        child_name:'Tax Rate Form',
        routeName:'Tax Rate',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          geo_zone_id: '',
          name: '',
          rate: '',
          type: ''
        },
        geoZone: [],
        customerGroup: []
      };
    },
    computed: {
    }, 
    created() {
      if(this.id){
        Flash.setLoading(true)
        this.getData()
      }
      this.getGeoZone()
      this.getCustomerGroup()
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.geo_zone_id = response['data']['geo_zone_id']
          this.formData.name = response['data']['name']
          this.formData.rate = response['data']['rate']
          this.formData.type = response['data']['type']
          Flash.setLoading(false)
        })
      },
      clear () {
        this.formData = {};
        this.$validator.reset()
      },
      getCustomerGroup() {
        fetchCustomerGroupList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['customer_group_id'],'name':response['data'][x]['name']}
            this.customerGroup.push(data)
          }
        })
      },
      getGeoZone() {
        fetchGeoZoneList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['geo_zone_id'],'name':response['data'][x]['name']}
            this.geoZone.push(data)
          }
        })
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