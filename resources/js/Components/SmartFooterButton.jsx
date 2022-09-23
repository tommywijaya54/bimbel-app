const SmartFooterButton = () => {
    const app = document.getElementById('app');
    const data = JSON.parse(app.dataset.page).props;
    const permissions = data.auth.permissions;

    return (<div className="px-6 py-4 bg-gray-50 flex items-center">
                <button type="button" className="text-red-600 hover:underline">Delete</button> 
                <button type="button" className="flex items-center btn-indigo ml-auto" >Update</button>
            </div>)
}
export default SmartFooterButton