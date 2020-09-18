<template>
  <card :title="$t('project_info_list')">
    <ul class="list-group">
      <li class="list-group-item" v-for="(value, key) in form.list">
        <router-link :to="'/settings/project_info_update/'+ value.id" class="nav-link" active-class="active">
          {{ value.name }} <img :src="value.img" >
        </router-link>

      </li>
    </ul>
      <ul>

      </ul>
  </card>
</template>

<script>
  import Form from 'vform'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      list: []
    })
  }),
  created () {
    this.project_info_list()
  },

  methods: {
    async project_info_list () {
      var data = await this.form.get('/api/project/list_for_info')
      this.form.list = data.data.data.list
    }
  }
}
</script>
