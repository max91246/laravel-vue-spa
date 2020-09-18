<template>
  <div class="row">
    <div class="col-md-3">
      <card :title="$t('settings')" class="settings-card">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <div v-if="tab.type == 'list'">
              <a class="nav-link " >
                <fa :icon="tab.icon" fixed-width />
                {{ tab.name }}
              </a>
              <ul class="nav flex-column nav-pills sencod">
                <li v-for="tab_class in tab.array" :key="tab_class.route" class="nav-item">
                  <router-link :to="{ name: tab_class.route }" class="nav-link" active-class="active">
                    {{ tab_class.name }}
                  </router-link>
                </li>
              </ul>
            </div>
            <div v-else>
              <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
                <fa :icon="tab.icon" fixed-width />
                {{ tab.name }}
              </router-link>
            </div>

          </li>
        </ul>
      </card>
    </div>

    <div class="col-md-9">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile',
          type: 'one'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password',
          type: 'one'
        },
        {
          icon: 'sign-out-alt',
          name: this.$t('big_project'),
          type: 'list',
          array: [
            {
              icon: 'sign-out-alt',
              name: this.$t('big_project_list'),
              route: 'settings.big_project_list'
            },
            {
              icon: 'sign-out-alt',
              name: this.$t('big_project_create'),
              route: 'settings.big_project_create'
            }
          ]
        },
        {
          icon: 'sign-out-alt',
          name: this.$t('project'),
          route: 'settings.project',
          type: 'list',
          array: [
            {
              icon: 'sign-out-alt',
              name: this.$t('project_list'),
              route: 'settings.project_list'
            },
            {
              icon: 'sign-out-alt',
              name: this.$t('project_create'),
              route: 'settings.project_create'
            }
          ]
        },
        {
          icon: 'sign-out-alt',
          name: this.$t('project_info'),
          route: 'settings.project_info',
          type: 'list',
          array: [
            {
              icon: 'sign-out-alt',
              name: this.$t('project_info_list'),
              route: 'settings.project_info_list'
            },
            {
              icon: 'sign-out-alt',
              name: this.$t('project_info_create'),
              route: 'settings.project_info_create'
            }
          ]
        },
        {
          icon: 'sign-out-alt',
          name: this.$t('project_size'),
          route: 'settings.project_size',
          type: 'list',
          array: [
            {
              icon: 'sign-out-alt',
              name: this.$t('project_size_list'),
              route: 'settings.project_size_list'
            },
            {
              icon: 'sign-out-alt',
              name: this.$t('project_size_create'),
              route: 'settings.project_size_create'
            }
          ]
        },
        {
          icon: 'sign-out-alt',
          name: this.$t('project_style'),
          route: 'settings.project_style',
          type: 'list',
          array: [
            {
              icon: 'sign-out-alt',
              name: this.$t('project_style_list'),
              route: 'settings.project_style_list'
            },
            {
              icon: 'sign-out-alt',
              name: this.$t('project_style_create'),
              route: 'settings.project_style_create'
            }
          ]
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
