import { useUserStore } from "@/store"

const useWithdraw = () => {
    const { getAccountData } = useUserStore()
    const { accountList } = storeToRefs(useUserStore())

    const coinList = computed(() => {
        return accountList.value.find(item => item.account_code === 'change_account')?.accounts.filter((item) => item.currency.open_recharge === 1) || []
    })

    getAccountData()

    return {
        coinList
    }
}

export default useWithdraw