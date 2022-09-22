export default ({list}) => {
    return <div className="array-list">
    {
    list.map((a, i) => {
        return <div className="item" key={i}>{a}</div>
    })
    }
    </div>
}