import { InertiaLink } from "@inertiajs/inertia-react"
import { useTransition } from "react"
import Icon from "./Icon"
import User from "./User"

export default ({users}) => {
    if(users.length == 0){
        return (<div className="inline-info">
            no user found
        </div>)
    }
    return <>
        <div className="list users">
            <h4>Users List</h4>
            {
                users.map((user, userId) => {
                    return <User key={userId} user={user}></User>
                })
            }
        </div>
    </>
}