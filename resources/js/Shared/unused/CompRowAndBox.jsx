export default ({header, note, footer, className, children}) => {
    return (
        <div className="ui-component row max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6 row">
            <div className={"box bg-white overflow-hidden shadow-lg sm:rounded-lg "+className}>
                
                {header && 
                    <div className="header ">
                        {header}
                    </div>
                }

                {note && 
                    <div className="note">
                        {note}
                    </div>
                }

                <div className="content info p-6 bg-white border-b border-gray-200">
                    {children}
                </div>

                {footer}
            </div>
        </div>
    );
}