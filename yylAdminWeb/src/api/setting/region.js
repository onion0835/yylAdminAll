import request from '@/utils/request'
// 地区管理
const url = '/admin/setting.Region/'
/**
 * 地区列表
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
 * 地区信息
 * @param {array} params 请求参数
 */
export function info(params) {
  return request({
    url: url + 'info',
    method: 'get',
    params: params
  })
}
/**
 * 地区添加
 * @param {array} data 请求数据
 */
export function add(data) {
  return request({
    url: url + 'add',
    method: 'post',
    data
  })
}
/**
 * 地区修改
 * @param {array} data 请求数据
 */
export function edit(data) {
  return request({
    url: url + 'edit',
    method: 'post',
    data
  })
}
/**
 * 地区删除
 * @param {array} data 请求数据
 */
export function dele(data) {
  return request({
    url: url + 'dele',
    method: 'post',
    data
  })
}
/**
 * 地区修改上级
 * @param {array} data 请求数据
 */
export function editpid(data) {
  return request({
    url: url + 'editpid',
    method: 'post',
    data
  })
}
/**
 * 地区修改区号
 * @param {array} data 请求数据
 */
export function citycode(data) {
  return request({
    url: url + 'citycode',
    method: 'post',
    data
  })
}
/**
 * 地区修改邮编
 * @param {array} data 请求数据
 */
export function zipcode(data) {
  return request({
    url: url + 'zipcode',
    method: 'post',
    data
  })
}
/**
 * 地区是否禁用
 * @param {array} data 请求数据
 */
export function disable(data) {
  return request({
    url: url + 'disable',
    method: 'post',
    data
  })
}
