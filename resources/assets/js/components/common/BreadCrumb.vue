<template>
    <!--Bread Camp for form -->
    <v-layout row class="align-center layout px-4 pt-4 app--page-header">
    <div class="page-header-left">
        <h3 class="pr-3">{{parent_name}}</h3>
    </div>
    <v-breadcrumbs divider="-">
        <v-breadcrumbs-item>
        <v-icon larg>home</v-icon>
        </v-breadcrumbs-item>
        <v-breadcrumbs-item>
            {{child_name}}
        </v-breadcrumbs-item>
    </v-breadcrumbs>
    <v-spacer></v-spacer>
    <div class="page-header-right">
        <!--<v-btn icon>
        <v-icon class="text--secondary">refresh</v-icon>
        </v-btn>-->
        <v-btn @click="backList()" color="default">
        <v-icon>reply</v-icon> Back to List
        </v-btn>

        <v-btn type="submit" color="primary">
        <v-icon>add</v-icon> Save
        </v-btn>
    </div>
    </v-layout><!--#End Bread Camp for form -->
</template>

<script>
  export default {
    props:[
        'routeName',
        'parent_name',
        'child_name'
    ],
    data () {
      return {
        
      }
    },
    methods:{
        backList(){
            this.$router.push({name:this.routeName})
        }
    }
  }
</script>