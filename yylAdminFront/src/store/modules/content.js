import { defineStore } from 'pinia';
import { reactive, ref } from 'vue';
import { list } from '@/api/front/content'

export const useContentStore = defineStore('content',()=>{
    const contentList = ref([])
    const catagory_tree = ref([])
    const currentCategory = ref(null);
    const count = ref({})
    const tag = ref({})
    const page = ref({})
    const pages = ref({})
    const hot = ref({})
    const tops = ref({})


/*
    function getContentList (data){
        console.log('getContentList');
        return new Promise((resolve,reject)=>{
            list(data).then((res)=>{
                console.log('getContentList',res);
                contentList.value  = res.data.list
                catagory_tree.value  = res.data.category
                console.log('catagory_tree',catagory_tree.value);
                console.log('res.data.category',res.data.category);
                count.value = res.data.count
                tag.value = res.data.tag
                page.value = res.data.page
                pages.value = res.data.pages
                hot.value = res.data.hot
                tops.value = res.data.tops



                resolve(res)
            })
        })

    }
*/
async function getContentList(category_id = null) {
    try {
        const res = await list({ category_id });
        console.log('API response:', res);  // 添加日志

        if (res.data && Array.isArray(res.data.list)) {
            contentList.value = res.data.list;
        } else {
            console.error('Invalid content list data:', res.data);
            contentList.value = [];
        }

        if (res.data && Array.isArray(res.data.category)) {
            catagory_tree.value = res.data.category;
        } else {
            console.error('Invalid menu items data:', res.data);
            catagory_tree.value = [];
        }

        currentCategory.value = category_id;
        return res;
    } catch (error) {
        console.error('Error fetching content list:', error);
        throw error;
    }
}
    return {
        contentList,
        catagory_tree,
        currentCategory,
        count,
        tag,
        page,
        pages,
        hot,
        tops,
        getContentList
    }
})

//定义返回contentStore状态的钩子方法，就不用在store下的index.js 一个一个初始化了
export function useContentStoreHook(){
    return useContentStore();
}
