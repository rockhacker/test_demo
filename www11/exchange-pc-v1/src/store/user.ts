import { getAccountList, getUserInfo } from "@/api/user";
import { Account, UserInfo } from "@/interface/user";
import Big from "big.js";
import { floor } from "lodash-es";
import { defineStore } from "pinia";

const appStore = defineStore(
  "user",
  () => {
    const token = ref<string>();

    const user = ref<UserInfo>()
    const userInputData = ref<{ account: string, password: string }>()

    const accountList = ref<Account[]>([])

    const isLogin = computed(() => !!user.value)

    const setToken = (data: string) => {
      token.value = data
    }

    const getUserData = (isInit = false) => {
      return getUserInfo({}, { isInit }).then(({ data }) => {
        user.value = data
      }).catch((err) => {
        console.error(err);
      })
    }

    const resetUserInfo = () => {
      token.value = user.value = undefined
      accountList.value = []
    }

    let getAccountDataPromise: Promise<any> | undefined

    const getAccountData = () => {
      if (getAccountDataPromise) return getAccountDataPromise

      getAccountDataPromise = getAccountList()
        .then(({ data }) => {
          accountList.value = data
        })
        .finally(() => {
          getAccountDataPromise = undefined
        })

      return getAccountDataPromise
    }

    const totalBalance = computed(() => {
      return accountList.value.reduce((prev, cur) => {
        return floor(Big(prev).plus(cur.convert_usd).toNumber(), 2)
      }, 0)
    })

    const totalLock = computed(() => {
      return accountList.value.reduce((prev, cur) => {
        return floor(Big(prev).plus(cur.convert_lock_usd).toNumber(), 2)
      }, 0)
    })

    const availableBalance = computed(() => {
      return floor(Big(totalBalance.value).minus(totalLock.value).toNumber(), 2)
    })

    return {
      token,
      setToken,
      user,
      userInputData,
      isLogin,
      getUserData,
      resetUserInfo,
      getAccountData,
      totalBalance,
      totalLock,
      availableBalance,
      accountList
    };
  },
  {
    persist: {
      storage: localStorage,
    },
  }
);

export default appStore;
