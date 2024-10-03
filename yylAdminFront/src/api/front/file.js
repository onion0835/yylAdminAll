import request from '@/utils/request'
//获取内容
const url = '/api/file.File/'

/**
 * 内容列表
 * 
http://localhost:9526/admin/content.Content/
list?page=1&limit=20&search_field=category_ids
&search_exp=like&date_field=create_time&search_value[]=
1&search_value[]=2
 * @param {array} params 请求参数
 */
export function list(params) {
  return request({
    url: url + 'list',
    method: 'get',
    params: params
  })
}

/**
 * 文件信息
 * @param {array} params 请求参数
 */
export function info(params) {
  return request({
    url: url + 'info',
    method: 'get',
    params: params
  })
}