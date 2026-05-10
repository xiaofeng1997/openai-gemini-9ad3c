import request from '@/utils/request'
/***************************************************** 主题风格 ****************************************************/


/**
 * 获取主题列表
 * @param params
 */
export function getDiyTheme(params: Record<string, any>) {
    return request.get(`diy/theme`, { params })
}

/**
 * 添加主题
 * @param params
 */
export function addDiyTheme(params: Record<string, any>) {
    return request.post(`diy/theme/add`, params, { showSuccessMessage: true })
}

/**
 * 编辑主题
 * @param params
 */
export function editDiyTheme(params: Record<string, any>) {
    return request.put(`diy/theme/edit/${ params.id }`, params, { showSuccessMessage: true })
}

/**
 * 删除主题
 * @param id
 */
export function delDiyTheme(id: number) {
    return request.delete(`diy/theme/delete/${ id }`, { showSuccessMessage: true })
}

/**
 * 设置主题
 * @param id
 */
export function setDiyTheme(id: number) {
    return request.put(`diy/theme/use/${ id }`, {}, { showSuccessMessage: true })
}

/**
 * 获取主题色字典
 */
export function getThemeColorDict(params: Record<string, any>) {
    return request.get(`diy/theme/color/dict`, { params })
}
