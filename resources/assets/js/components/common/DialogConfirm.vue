<template>
  <v-layout row justify-center>
    <v-dialog
    v-model="dialog"
    max-width="300"
    >
    <v-card>
        <!--<v-card-title class="headline">Confirm Message</v-card-title>-->
        <v-card-text>
            <center><h3>Are you sure to delete?</h3></center>
        </v-card-text>

        <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn
            color="green darken-1"
            flat="flat"
            @click="dialogNo()"
        >
            No
        </v-btn>

        <v-btn
            color="green darken-1"
            flat="flat"
            @click="dialogYes()"
        >
            Yes
        </v-btn>
        </v-card-actions>
    </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
  export default {    
    data () {
      return {
        dialog: false,
        id:''
      }
    },
    methods:{
        child_method(dialog,dataId){
            this.dialog = dialog
            this.id = dataId
        },
        dialogNo(){
            this.dialog = false
            let _dialogMessage = "no"
            this.$emit('event_child', _dialogMessage,this.id)
        },
        dialogYes(){
            this.dialog = false
            let _dialogMessage = "yes"
            this.$emit('event_child', _dialogMessage,this.id)
        }
    }
  }
</script>