'use strict'

import { StrictMode } from 'react'
import * as ReactDOM from 'react-dom/client'
import { Footer, Header, Layout, Main } from './components'
import './styles.scss'

const root = ReactDOM.createRoot(document.getElementById('root'))

root.render(
    <StrictMode>
        <Layout>
            <Header>
                <div className="container">Header</div>
            </Header>
            <Main>
                <div className="container">
                    <h1>Hello World!</h1>
                </div>
            </Main>
            <Footer>
                <div className="container">Footer</div>
            </Footer>
        </Layout>
    </StrictMode>
)
