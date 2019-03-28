<template>
    <!--toast message-->
    <div slot="widget-content">
        <v-alert v-if="notifyStatus=='success'" type="success" dismissible :value="true">
            {{message}}
        </v-alert>
        <v-alert v-if="notifyStatus=='info'" type="info" dismissible :value="true">
            {{message}}
        </v-alert>
        <v-alert v-if="notifyStatus=='warning'" type="warning" dismissible :value="true">
            {{message}}
        </v-alert>
        <v-alert v-if="notifyStatus=='error'" type="error" dismissible :value="true">
            {{message}}
        </v-alert>
    </div><!--toast message-->
</template>

<script>
    export default{
        props:[
                'notifyStatus',
                'message'
              ],
        data () {
            return {
                email: '',
                valid: true
            };
        }
    }    
</script>