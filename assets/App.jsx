var Navbar = Reactstrap.Navbar;
var NavbarBrand = Reactstrap.NavbarBrand;
var NavbarToggler = Reactstrap.NavbarToggler;
var Collapse = Reactstrap.Collapse;
var Nav = Reactstrap.Nav;
var NavItem = Reactstrap.NavItem;
var NavLink = Reactstrap.NavLink;
var UncontrolledDropdown = Reactstrap.UncontrolledDropdown;
var DropdownToggle =  Reactstrap.DropdownToggle;
var DropdownMenu = Reactstrap.DropdownMenu;
var DropdownItem = Reactstrap.DropdownItem;
var Container = Reactstrap.Container;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;

class App extends React.Component {
    constructor(props) {
        super(props)
        this.state = { programs: [], program: [], revisiones: []}
        this.handleReload = this.handleReload.bind(this);
        this.handleChangeData = this.handleChangeData.bind(this);
        this.handleChangeProgram = this.handleChangeProgram.bind(this);
    }
    handleReload() {
        fetch('./server/index.php/programa')
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            this.setState({ programs: data });
            this.forceUpdate();
        })
    }
    componentWillMount() {
        this.handleReload();
    }
    handleChangeData() {
        this.handleReload();
    }
    handleChangeProgram(data) {
        this.setState({program: data})
    }
    render() {
        return (<div><Navbar color="light" light expand="md">
          <NavbarBrand href="/">Datos de Países</NavbarBrand>
          <NavbarToggler onClick={this.toggle} />
          <Collapse isOpen={this.state.isOpen} navbar>
            <Nav className="ml-auto" navbar>
              <NavItem>
                <NavLink href="http://programacion-con-reactjs.readthedocs.io">Tutorial</NavLink>
              </NavItem>
              <UncontrolledDropdown nav inNavbar>
                <DropdownToggle nav caret>
                  Options
                </DropdownToggle>
                <DropdownMenu right>
                  <DropdownItem>
                    Option 1
                  </DropdownItem>
                  <DropdownItem>
                    Option 2
                  </DropdownItem>
                  <DropdownItem divider />
                  <DropdownItem>
                    Reset
                  </DropdownItem>
                </DropdownMenu>
              </UncontrolledDropdown>
            </Nav>
          </Collapse>
        </Navbar><Container>
        <Row>
            <Col xs="4">
                <ProgramList programs={this.state.programs} handleChangeProgram={this.handleChangeProgram}/>
            </Col>
            <Col xs="8">
                <Row>
                    <Col xs="12">
                        <ProgramForm program={this.state.program} handleChangeData={this.handleChangeData}/>
                    </Col>
                </Row>
            </Col>
        </Row>
        <hr/>
        <Row>
            <Col xs="4">
                <HistorialList revisiones={this.state.revisiones} handleChangeProgram={this.handleChangeProgram}/>
            </Col>
            <Col xs="8">
                <Row>
                    <Col xs="12">
                        <ProgramForm program={this.state.program} handleChangeData={this.handleChangeData}/>
                    </Col>
                </Row>
            </Col>
        </Row>
        </Container></div>)
    }
}
ReactDOM.render(<App/>, document.getElementById('root'));