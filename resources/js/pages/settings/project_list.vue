<template>
  <card :title="$t('project_list')">
    <table class="table">
      <thead>
      <tr>
        <th scope="col">名稱</th>
        <th scope="col">圖片</th>
        <th scope="col">金額</th>
        <th scope="col">明細</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(value, key) in form.list">
        <th scope="row">
          <router-link :to="'/settings/project_update/'+ value.id" class="nav-link" active-class="active">
            {{ value.name }}
          </router-link>
        </th>
        <td><img :src="value.img"></td>
        <td>{{ value.amount }}</td>
        <td>
          <div v-if="value.project_info.length > 0">
            <div  v-for="(project_info_v, key) in value.project_info" >
              {{project_info_v.size.name}} - {{project_info_v.style.name}} - 數量：{{project_info_v.num}}
            </div>
            <router-link :to="'/settings/project_info_create/' + value.id" class="nav-link" active-class="active">
              修改商品明細
            </router-link>
          </div>
          <div v-else>
            <router-link to="/settings/project_info_create/" class="nav-link" active-class="active">
              新增商品明細
            </router-link>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
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
    this.project_list()
  },

  methods: {
    async project_list () {
      var data = await this.form.get('/api/project/list')
      this.form.list = data.data.data.list
    }
  }
}
</script>
