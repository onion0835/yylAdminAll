import { defineStore } from 'pinia';
import { reactive, ref } from 'vue';
import { list } from '@/api/front/content'

export const useContentStore = defineStore('content',()=>{
    const contentItems = ref([])
    const topsItems = ref([])
    const hotsItems = ref([])
    const recsItems = ref([])

    const menuItems = ref([])
    const currentCategory = ref(null);
    const count = ref(0)
    const tag = ref({})
    const page = ref(1)
    const pages = ref(1)
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
async function getContentList(category_id = null,initialPage = 1,limit = 10) {
    try {
        const res = await list({ category_id,page: initialPage,limit });
        console.log('API response:', res);  // 添加日志

        if (res.data && Array.isArray(res.data.list)) {
            contentItems.value = res.data.list;

            topsItems.value = res.data.tops;
            console.log('useContentStore topsItems',topsItems.value)
            console.log('useContentStore res.data.tops',res.data.tops)
            hotsItems.value = res.data.hots;
            recsItems.value = res.data.recs;
            count.value = res.data.count;
            pages.value = res.data.pages;
            page.value = res.data.page;
            
        } else {
            console.error('Invalid content list data:', res.data);
            contentItems.value = [];
            topsItems.value = [];
            hotsItems.value = [];
            recsItems.value = [];
            count.value = 0;
            page.value = 0;
            pages.value = 0;
        }

        if (res.data && Array.isArray(res.data.category)) {
            menuItems.value = res.data.category;
        } else {
            console.error('Invalid menu items data:', res.data);
            menuItems.value = [];
        }

        currentCategory.value = category_id;
        return res;
    } catch (error) {
        console.error('Error fetching content list:', error);
        throw error;
    }
}
    return {
        contentItems,
        topsItems,
        hotsItems,
        recsItems,
        menuItems,
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
