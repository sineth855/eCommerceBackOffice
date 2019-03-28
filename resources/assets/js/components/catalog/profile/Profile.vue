<template>
  <div id="pageTable">
    <v-container grid-list-xl fluid>
      <!--toast message-->
      <message
        ref="child"
        :notifyStatus="notifyStatus"
        :message="message" > 
      ></message><!--#End toast message-->
      <!--#Dialog Message-->
      <dialog-confirm 
        ref="child"
        v-on:event_child="eventChild">
      </dialog-confirm><!--#End Dialog Message-->

      <v-layout row wrap>
        <!--<v-flex sm12>
          <h3>Category Index</h3>
        </v-flex>-->
        <v-flex lg12>
            <v-card class="mt-3">
                <v-card-media src="./img/static/bg/15.jpg" height="300px">
                <v-layout column class="media">
                    <v-card-title class="white--text pl-5 pt-5">
                    <div class="display-1 pl-5 pt-5">{{ profile.firstname }} {{ profile.lastname }}</div>
                    </v-card-title>
                </v-layout>
                </v-card-media>
                <v-list two-line>
                <v-list-tile href="">
                    <v-list-tile-action>
                    <v-icon color="indigo">phone</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                    <v-list-tile-title>{{ profile.telephone_1 }}</v-list-tile-title>
                    <v-list-tile-sub-title>Mobile</v-list-tile-sub-title>
                    </v-list-tile-content>
                    <v-list-tile-action>
                    <v-icon>chat</v-icon>
                    </v-list-tile-action>
                </v-list-tile>
                <v-list-tile href="#">
                    <v-list-tile-action></v-list-tile-action>
                    <v-list-tile-content>
                    <v-list-tile-title>{{ profile.telephone_2 }}</v-list-tile-title>
                    <v-list-tile-sub-title>Work</v-list-tile-sub-title>
                    </v-list-tile-content>
                    <v-list-tile-action>
                    <v-icon>chat</v-icon>
                    </v-list-tile-action>
                </v-list-tile>
                <v-divider inset></v-divider>
                <v-list-tile href="#">
                    <v-list-tile-action>
                    <v-icon color="indigo">mail</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                    <v-list-tile-title>{{ profile.email }}</v-list-tile-title>
                    <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile href="#">
                    <v-list-tile-action></v-list-tile-action>
                    <v-list-tile-content>
                    <v-list-tile-title>{{ profile.email_2 }}</v-list-tile-title>
                    <v-list-tile-sub-title>Work</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-divider inset></v-divider>
                <v-list-tile href="#">
                    <v-list-tile-action>
                    <v-icon color="indigo">location_on</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                    <v-list-tile-title>{{ profile.address_1 }}</v-list-tile-title>
                    <v-list-tile-sub-title>Address</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
                </v-list>
            </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>

  import {fetchProfile} from '~/api/catalog/profile'
  import Message from '~/components/common/Message'
  import DialogConfirm from '~/components/common/DialogConfirm'
  import {fetchList,updateData,deleteData} from '~/api/catalog/product'
  import Flash from '~/services/flash'
  export default {
    data () {
      return {
        routeName: 'ProductForm',
        routeUrl: '/catalog/product',
        search: '',
        items: [],
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        dialog:false,
        profile: {},
        colors: {
          warning: 'blue',
          danger: 'red',
          success: 'green'
        },
        complex: {
          selected: [],
          headers: [
            {
              text: 'ID',
              value: 'id'
            },
            {
              text: 'Image',
              value: 'image'
            },
            {
              text: 'Product Name',
              value: 'name'
            },
            {
              text: 'Model',
              value: 'model'
            },
            {
              text: 'Price',
              value: 'price'
            },
            {
              text: 'Quantity',
              value: 'quantity'
            },
            {
              text: 'Status',
              value: 'status'
            },
            {
              text: 'Action',
              value: ''
            },
          ]
        }
      };
    },
    components: {
      Message,
      DialogConfirm
    },
    created(){
      Flash.setLoading(true)
      this.getProfile()
    },
    methods:{
      getProfile() {
        fetchProfile().then(response => {
          Flash.setLoading(false)
          this.profile = response
        })
      },
      getColorByStatus (status) {
        return this.colors[status];
      },
      viewEdit(id){
        this.$router.push(this.routeUrl+'/'+id)
      },
      createNew(){
        this.$router.push({name:this.routeName})
      },
      eventChild: function(_dialogMessage,dataId) {
        if(_dialogMessage=='yes'){
          deleteData(dataId).then(response => {
            if(response.success == true){
              this.notifyStatus = 'success'
              this.message = response.message
              this.getData()
            }else{
              this.notifyStatus = 'error'
              this.message = response.message
            }
          })
        }
      },
      btnConfirm(id){
        this.dialog = true
        this.$refs.child.child_method(this.dialog,id)
      },
    }
  }
</script>
