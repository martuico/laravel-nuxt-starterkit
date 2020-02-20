/// <reference types="cypress" />

context('Login', () => {
  beforeEach(() => {
    cy.visit('http://localhost:3000/auth/login')
  })

  it('.submit() - submit a login', () => {
    // https://on.cypress.io/submit
    cy.get('.form-action')
      .find('[name="email"]')
      .type('mar@mail.com')
    cy.get('.form-action')
      .find('[name="password"]')
      .type('password')
    cy.get('button').click()
  })
})
