<template>
  <v-app light>
    <div id="appRoot" v-if="authenticated">
      <span v-if="flash.loading">
        <loading></loading>
      </span>
      <template v-if="!$route.meta.public">
        <v-app id="inspire" class="app">
          <app-drawer class="app--drawer"></app-drawer>
          <app-toolbar class="app--toolbar"></app-toolbar>
          <v-content>
            <!-- Page Header -->
            <page-header v-if="$route.meta.breadcrumb"></page-header>
            <div class="page-wrapper">
              <router-view></router-view>
            </div>   
            <!-- App Footer -->
            <v-footer height="auto" class="white pa-3 app--footer">
              <span class="caption">Bakou System &copy; {{ new Date().getFullYear() }}</span>
              <v-spacer></v-spacer>
              <span class="caption mr-1"> All Right Reserved. </span> <v-icon color="pink" small>favorite</v-icon>
            </v-footer>
          </v-content>
          <!-- Go to top -->
          <app-fab></app-fab>
          <!-- theme setting -->
          <v-btn small fab dark falt fixed top="top" right="right" class="setting-fab" color="red" @click="openThemeSettings">
            <v-icon>settings</v-icon>
          </v-btn>
          <v-navigation-drawer
            class="setting-drawer"
            temporary
            right
            v-model="rightDrawer"
            hide-overlay
            fixed
            >
            <theme-settings></theme-settings>
          </v-navigation-drawer>        
        </v-app>
      </template>
      <template v-else>
        <transition>
          <keep-alive>
            <router-view></router-view>
          </keep-alive>
        </transition>
      </template>
      <v-snackbar
        :timeout="3000"
        bottom
        right
        :color="snackbar.color"
        v-model="snackbar.show"
      >
        {{ snackbar.text }}
        <v-btn dark flat @click.native="snackbar.show = false" icon> 
          <v-icon>close</v-icon>
        </v-btn>
      </v-snackbar>    
    </div>
    <div v-else>
      <router-view></router-view>
    </div>
    <!--<v-navigation-drawer 
      v-if="authenticated" 
      persistent 
      v-model="drawer" 
      enable-resize-watcher 
      app
    >
      <nav-menu></nav-menu>
    </v-navigation-drawer>
    <tool-bar v-on:toggleDrawer="drawer = !drawer" :drawer="drawer"></tool-bar>
    <v-content>
      <v-container fluid>
        <transition name="page" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-container>
    </v-content>
    <feedback-message></feedback-message>
    <page-footer></page-footer>-->
  </v-app>
</template>

<script>

import Loading from '~/components/common/Loading.vue'
import Flash from '~/services/flash'
import AppDrawer from '~/components/AppDrawer';
import AppToolbar from '~/components/AppToolbar';
import AppFab from '~/components/AppFab';
import PageHeader from '~/components/PageHeader';
import menu from '~/api/menu';
import ThemeSettings from '~/components/ThemeSettings';
import AppEvents from  '~/event';

import { mapGetters } from 'vuex'

import NavMenu from '~/components/NavMenu'
import ToolBar from '~/components/ToolBar'
import FeedbackMessage from '~/components/FeedbackMessage'
import PageFooter from '~/components/PageFooter'

export default {
  components: {
    Loading,
    AppDrawer,
    AppToolbar,
    AppFab,
    PageHeader,
    ThemeSettings,
    'nav-menu': NavMenu,
    'tool-bar': ToolBar,
    'feedback-message': FeedbackMessage,
    'page-footer': PageFooter
  },

  computed: mapGetters({
    authenticated: 'authCheck'
  }),
  created () {
    AppEvents.forEach(item => {
      this.$on(item.name, item.callback);
    });
    window.getApp = this;
  },
  methods: {
    openThemeSettings () {
      this.$vuetify.goTo(0);
      this.rightDrawer = (!this.rightDrawer);
    }
  },
  data () {
    return {
      isShow:false,
      expanded: true,
      rightDrawer: false,
      flash: Flash.state,
      snackbar: {
        show: false,
        text: '',
        color: '',
      },
      drawer: true
    }
  }
}
</script>

<style lang="stylus" scoped>
  .setting-fab 
    top:50%!important; 
    right:0;
    border-radius:0  
  .page-wrapper
    min-height:calc(100vh - 64px - 50px - 81px );  

</style>
